declare var laroute: Laroute;

interface Laroute {
    route: (name: string, parameters?: object) => string,
}
