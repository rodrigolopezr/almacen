import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {},
  getters: {},
  mutations: {},
  actions: {
    getProducts() {
      return new Promise((resolve, reject) => {
        axios
          .get(`${process.env.VUE_APP_API_BASE_URL}/producto/get`)
          .then((response) => {
            const { data } = response;

            data.productos.map((item) => {
              switch (item.categoria.id) {
                case 1:
                  item["CostoPublico"] = new Intl.NumberFormat().format(
                    item.Costo * 1.35
                  );
                  break;
                case 2:
                  item["CostoPublico"] = new Intl.NumberFormat().format(
                    item.Costo * 1.4
                  );
                  break;
                case 3:
                  item["CostoPublico"] = new Intl.NumberFormat().format(
                    item.Costo * 1.3
                  );
                  break;
              }
            });

            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    getCategories() {
      return new Promise((resolve, reject) => {
        axios
          .get(`${process.env.VUE_APP_API_BASE_URL}/categoria/get`)
          .then((response) => {
            const { data } = response;

            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    saveProducts(_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .post(`${process.env.VUE_APP_API_BASE_URL}/producto/new`, payload)
          .then((response) => {
            const { data } = response;

            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
    deleteProducts(_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .delete(
            `${process.env.VUE_APP_API_BASE_URL}/producto/delete/${payload.id}`
          )
          .then((response) => {
            const { data } = response;

            resolve(data);
          })
          .catch((err) => {
            reject(err);
          });
      });
    },
  },
  modules: {},
});
