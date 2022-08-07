export function priceFormat(_price) {
  let price = Number(_price).toLocaleString()

  return '¥' + price
}
