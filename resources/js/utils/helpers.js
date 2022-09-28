export function dateDiffInDays(a, b) {
    let _MS_PER_DAY = 1000 * 60 * 60 * 24
    return Math.ceil(Math.round(a - b) / _MS_PER_DAY)
}

export default { dateDiffInDays }
