export const getElAttribute = (id: string, attribute: string) => {
    const el = document.getElementById(id) as HTMLElement;
    const attr = el.getAttribute(attribute) ?? null;

    return attr;
}

export const parseJson = (id: string) => {
    const el = document.getElementById(id) as HTMLScriptElement;
    const json = JSON.parse(el.text) ?? null;

    return json;
}
