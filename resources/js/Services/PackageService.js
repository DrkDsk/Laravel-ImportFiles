export function checkIfShowStatesOrOrings(originsOrStates, mediumName) {
    let data = []

    if (mediumName === "OOH") {
        originsOrStates.forEach(state => {
            let nameAsLowerCase = state.state.name.toLowerCase()
            let firstLetterToCapitalize = nameAsLowerCase.charAt(0).toUpperCase() + nameAsLowerCase.slice(1)
            data.push(firstLetterToCapitalize)
        })

        return data
    }

    originsOrStates.forEach(origin => {
        let nameAsLowerCase = origin.origin.name.toLowerCase()
        let firstLetterToCapitalize = nameAsLowerCase.charAt(0).toUpperCase() + nameAsLowerCase.slice(1)
        data.push(firstLetterToCapitalize)
    })

    return data
}

export default {
    checkIfShowStatesOrOrings
}
