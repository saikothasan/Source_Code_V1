export default {
    data() {
        return {
            isLoading: false,
        };
        
    },
    methods: {
        routeName(name) {
            return route(name);
        },
        newTab(url) {
            window.open(url, "_blank");
        },
        reload(time) {
            setTimeout(() => {
                window.location.reload();
            }, time);
        },
        Slugify: function (text) {
            let slug = "";
            let titleLower = text.toLowerCase();
            slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, "e");
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, "a");
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, "o");
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, "u");
            slug = slug.replace(/đ/gi, "d");
            slug = slug.replace(/\s*$/g, "");
            slug = slug.replace(/\s+/g, "-");
            slug = slug.replace("'", "");
            slug = slug.replace("&", "and");
            slug = slug.replace("/", "-");
            slug = slug.replace("?", "");
            return slug;
        },
        capitalize(event) {
            return event.target.value.replace(/(?:^|\s)\S/g, function (a) {
                return a.toUpperCase();
            });
        },
        playSound: function () {
            let sound = "/audio/error.mp3";
            let audio = new Audio(sound);
            audio.play();
        },
        formReset: function (form) {
            Object.keys(form).forEach(function (key, index) {
                form[key] = "";
            });
        },
        objectArrayReset: function (form) {
            Object.keys(form).forEach(function (key, index) {
                form[key] = [];
            });
        },
        modalRest: function (modelName) {
            this.$modal.hide(modelName);
        },
        validationReset: function () {
            this.$vuelidation.reset();
        },
        Loader: function (loader) {
            if (loader === true) {
                $("#apploader").show();
            } else if (loader === false) {
                $("#apploader").hide();
            } else {
                $("#apploader").show();
                setTimeout(() => $("#apploader").hide(), 500);
            }
        },
        objectValueReset: function (form) {
            Object.keys(form).forEach(function (key, index) {
                form[key] = "";
            });
        },
    },
};
