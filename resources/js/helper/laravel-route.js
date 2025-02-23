let routes = window.Laravel.routes
module.exports = function () {
    let args = Array.prototype.slice.call(arguments);
    let name = args.shift();
    if (routes[name] === undefined) {
        alert(`'Route not found ' ${name}`)
    } else {
        return window.Laravel.baseUrl + '/' + routes[name]
            .split('/')
            .map(s => s[0] == '{' ? args.shift() : s)
            .join('/');
    }
};
