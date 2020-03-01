declare var authUser: User;
declare var laroute: Laroute;

interface Answer {
    answer: string,
    question: string,
}

interface Application {
    answers: Answer[],
    approved: boolean,
    created_at: Date,
    feedback?: string,
    feedback_author?: User,
    id: number,
    gamemode: 'osu!' | 'osu!catch' | 'osu!mania' | 'osu!taiko',
    user: User,
    verdict?: 'fail' | 'pass',
}

interface Laroute {
    route: (name: string, parameters?: object) => string,
}

interface User {
    id: number,
    is_admin?: boolean,
    username: string,
}
