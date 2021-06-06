import { createStore } from "vuex";

export default createStore({
    state: {
        token: null,
        pass: null,
        message: null,
        dataUsers: null,
        dataHome: null,
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        setPass(state, pass) {
            state.pass = pass;
        },
        setMessage(state, message) {
            state.message = message;
        },
        setDataUsers(state, dataUsers) {
            state.dataUsers = dataUsers;
        },
        setDataHome(state, dataHome) {
            state.dataHome = dataHome;
        },
    },
    actions: {
        async login({ commit }, usuario) {
            console.log(usuario);
            try {
                const res = await fetch("http://127.0.0.1:8000/api/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(usuario),
                });
                const resData = await res.json();
                const token = resData.token;

                localStorage.setItem("token", token);
                commit("setToken", token);
                getDataUsers();
            } catch (error) {
                console.log(error);
            }
        },
        readToken({ commit }) {
            const token = localStorage.getItem("token");
            if (token) {
                commit("setToken", token);
            } else {
                commit("setToken", null);
            }
        },
        logout({ commit }) {
            localStorage.removeItem("token");
            commit("setToken", null);
        },
        async recoveryPass({ commit }, forgetPass) {
            try {
                const res = await fetch(
                    "http://127.0.0.1:8000/api/recoveryPass",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(forgetPass),
                    }
                );
                const resData = await res.json();

                console.log(resData);

                commit("setPass", resData);
            } catch (error) {
                console.log(error);
            }
        },
        async contactanos({ commit }, contacto) {
            try {
                const res = await fetch(
                    "http://127.0.0.1:8000/api/contactanos",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(contacto),
                    }
                );
                const resData = await res.json();

                console.log(resData);

                commit("setMessage", resData);
            } catch (error) {
                console.log(error);
            }
        },
        async getDataUsers({ commit }) {
            try {
                const res = await fetch("http://127.0.0.1:8000/api/dataUsers", {
                    headers: {
                        "Content-Type": "application/json",
                        "auth-token": this.state.token,
                    },
                });
                const resData = await res.json();
                commit("setDataUsers", resData);
            } catch (error) {
                console.log(error);
            }
        },
        async getDataHome({ commit }) {
            try {
                const res = await fetch(
                    "http://127.0.0.1:8000/api/customize",
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );
                const resData = await res.json();
                commit("setDataHome", resData);
            } catch (error) {
                console.log(error);
            }
        },
    },
    modules: {},
});
