declare var laroute: Laroute;
declare var authUser: User;

interface Laroute {
    route: (name: string, parameters?: object) => string,
}

interface User {
    id: number,
    is_admin?: boolean,
    username: string,
}
