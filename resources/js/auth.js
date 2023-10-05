
let features = {
    assessments: {
        edit: ['admin'],
        create: ['admin'],
        view: ['admin', 'editor'],
    }
}


export const auth = {
    can : (role, ability, feature) => {

        let permission = features[feature][ability];
        return permission.some((allowed) => role === allowed);
    }
}