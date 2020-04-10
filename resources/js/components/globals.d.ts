declare var authUser: User;
declare var laroute: Laroute;

interface Answer {
    answer: string,
    question: Question;
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

interface Nomination {
    artist: string,
    beatmap_id: number,
    creator: string,
    creator_osu_id: number,
    id: number,
    nominator: User,
    score: number,
    spots_id: number,
    title: string,
    votes: Vote[],
}

interface JQuery {
    tooltip(): void,
}

interface Question {
    char_limit: number,
    children?: Question[],
    description?: string,
    id: number,
    order: number,
    question: string,
    required: boolean,
    relation: 'alone' | 'parent' | 'child',
    type: 'checkbox' | 'input' | 'section' | 'textarea',
}

interface Spotlights {
    id: number,
    nominations: Nomination[],
    threshold?: number,
}

interface SpotlightsStatistic {
    name: string,
    value: number | string,
}

interface User {
    id: number,
    is_admin?: boolean,
    username: string,
}

interface Vote {
    comment: string,
    comment_updated_at?: Date,
    created_at: Date,
    id: number,
    value: number,
    voter: User,
}
