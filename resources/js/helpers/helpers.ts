export const classModified = (className: string, modidifers: string[]) => {
    let finalClass = className;

    modidifers.forEach(modidifer => {
        finalClass += ` ${className}--${modidifer}`
    });

    return finalClass;
}

export const gamemode = (mode: string): string => {
    let formattedGamemode;

    mode === 'osu'
        ? formattedGamemode = 'osu!'
        : formattedGamemode = `osu!${mode}`;

    return formattedGamemode;
}

export const getElAttribute = (id: string, attribute: string) => {
    const el = document.getElementById(id) as HTMLElement;
    const attr = el.getAttribute(attribute) ?? null;

    return attr;
}

export const parseJson = (id: string) => {
    if (document.getElementById(id)) {
        const el = document.getElementById(id) as HTMLScriptElement;
        const json = JSON.parse(el.text) ?? null;

        return json;
    }
}
