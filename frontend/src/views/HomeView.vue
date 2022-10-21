<!-- eslint-disable vue/valid-v-slot -->
<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="products"
      sort-by="Id"
      class="elevation-1"
      :search="search"
      :loading="loading"
      :single-expand="singleExpand"
      :expanded.sync="expanded"
      show-expand
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="success"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
                fab
              >
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.Nombre"
                        label="Nombre"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.SKU"
                        label="SKU"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.Marca"
                        label="Marca"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-model="editedItem.Costo"
                        label="Costo"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-select
                        v-model="editedItem.categoria_id"
                        :items="categories"
                        item-text="Nombre"
                        item-value="id"
                      ></v-select>
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" class="text-center"
                      ><span class="font-weight-bold text-center"
                        >Atributos</span
                      ></v-col
                    >
                  </v-row>
                  <v-divider />
                  <v-row>
                    <v-col cols="3" class="mt-5">
                      <span>{{ labelAttribute }}</span>
                    </v-col>
                    <v-col cols="9">
                      <template v-if="editedItem.categoria_id === 1">
                        <v-select :items="typesScreen" v-model="attributeOne">
                        </v-select>
                      </template>
                      <template v-if="editedItem.categoria_id === 2">
                        <v-select
                          :items="processors"
                          v-model="attributeOne"
                        ></v-select>
                      </template>
                      <template v-if="editedItem.categoria_id === 3">
                        <v-select
                          :items="tipesShoes"
                          v-model="attributeOne"
                        ></v-select>
                      </template>
                    </v-col>

                    <v-col cols="3" class="mt-5">
                      <span>{{ labelAttributeTwo }}</span>
                    </v-col>
                    <v-col cols="9">
                      <v-text-field
                        v-if="editedItem.categoria_id"
                        v-model="attributeTwo"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error darken-1" @click="close"> Cancelar </v-btn>
                <v-btn
                  color="success darken-1"
                  @click="save"
                  :loading="loading"
                  :disabled="loading"
                >
                  Guardar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5"
                >¿Estás seguro de eliminar este elemento?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancelar</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >Aceptar</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="getProducts"> Reset </v-btn>
      </template>
      <template v-slot:expanded-item="{ headers, item }">
        <td :colspan="headers.length">
          <ul>
            <li v-for="(atributo, index) in item.atributos" :key="index">
              {{ `${atributo.Nombre} : ${atributo.Valor} ` }}
            </li>
          </ul>
        </td>
      </template>
    </v-data-table>
    <v-snackbar v-model="alert" color="success">
      Proceso realizado con exito
    </v-snackbar>
  </v-container>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "HomeView",
  data: () => ({
    products: [],
    categories: [],
    expanded: [],
    singleExpand: false,
    alert: false,
    headers: [
      {
        text: "Id",
        align: " d-none",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "Nombre" },
      { text: "SKU", value: "SKU" },
      { text: "Marca", value: "Marca" },
      { text: "Costo", value: "Costo" },
      { text: "Costo al Publico", value: "CostoPublico" },
      { text: "Categoria", value: "categoria.Nombre" },
      { text: "Actions", value: "actions", sortable: false },
    ],
    dialog: false,
    dialogDelete: false,
    loading: false,
    editedIndex: -1,
    editedItem: {
      id: 0,
      Nombre: "",
      SKU: "",
      Marca: "",
      Costo: "",
      categoria_id: 0,
    },
    defaultItem: {
      id: 0,
      Nombre: "",
      SKU: "",
      Marca: "",
      Costo: "",
      categoria_id: 0,
    },
    search: "",
    typesScreen: ["LED", "LCD", "OLED"],
    processors: ["Intel", "AMD"],
    tipesShoes: ["Piel", "Plástico"],
    labelAttribute: "",
    labelAttributeTwo: "",
    attributeOne: "",
    attributeTwo: "",
  }),
  async mounted() {
    await this.getProductsStore();
    const { categorias } = await this.getCategories();
    this.categories = categorias;
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Producto" : "Editar Producto";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    "editedItem.categoria_id"(val) {
      switch (val) {
        case 1:
          this.labelAttribute = "Tipo de pantalla";
          this.labelAttributeTwo = "Tamaño de pantalla";
          break;
        case 2:
          this.labelAttribute = "Procesador";
          this.labelAttributeTwo = "Memoria Ram";
          break;
        case 3:
          this.labelAttribute = "Material";
          this.labelAttributeTwo = "Numero / Tamaño";
          break;
        default:
          this.labelAttribute = "";
          this.labelAttributeTwo = "";
          break;
      }
    },
  },
  methods: {
    ...mapActions({
      getProducts: "getProducts",
      getCategories: "getCategories",
      saveProducts: "saveProducts",
      deleteProducts: "deleteProducts",
    }),
    editItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.products.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    async deleteItemConfirm() {
      try {
        const payload = {
          id: this.editedItem.id,
        };

        await this.deleteProducts(payload);
        await this.getProductsStore();
        this.alert = true;
      } catch (error) {
        console.error(error);
      }
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    async save() {
      try {
        this.loading = true;
        const payload = {
          producto: {
            ...this.editedItem,
          },
          atributos: [
            {
              Nombre: this.labelAttribute,
              Valor: this.attributeOne,
            },
            {
              Nombre: this.labelAttributeTwo,
              Valor: this.attributeTwo,
            },
          ],
        };

        if (this.editedIndex === -1) {
          await this.saveProducts(payload);
          await this.getProductsStore();
          this.alert = true;
          this.close();
        }
      } catch (error) {
        console.log(error);
        this.loading = false;
      }
    },
    async getProductsStore() {
      try {
        this.loading = true;
        const { productos } = await this.getProducts();
        this.products = productos;
      } catch (error) {
        this.loading = false;
        console.error(error);
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
