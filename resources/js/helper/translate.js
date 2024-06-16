import axios from "axios";

export default class Translate {
    async translate(keys) {
        const data = {
            keys: keys,
        };

        try {
            const response = await axios.post(route("language.vue-get"), data);
            console.log(response.data);
            return response.data;
        } catch (error) {
            console.error(error);
            return {};
        }
    }
}
