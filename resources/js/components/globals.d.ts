declare var authUser: User;
declare var laroute: Laroute;

interface Laroute {
    route: (name: string, parameters?: object) => string,
}

interface User {
    id: number,
    is_admin?: boolean,
    username: string,
}
