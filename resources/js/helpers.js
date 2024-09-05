export function inArray(item, array, key = null){

    return array.some( (selected) => ( selected[key] ?? selected ) == item );
}


export function removeItem(item, array, key = null){

    return array.filter( (selected) => ( selected[key] ?? selected ) != item );
}