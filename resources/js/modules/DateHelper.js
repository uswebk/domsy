export function shortHyphenDate(dateTime) {
  if (dateTime === null) {
    return null
  }

  let date = new Date(dateTime)

  let formattedDate =
    date.getFullYear() +
    '-' +
    (date.getMonth() + 1).toString().padStart(2, '0') +
    '-' +
    date.getDate().toString().padStart(2, '0')

  return formattedDate
}
