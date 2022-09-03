export default ({ app }, inject) => {
  inject('formattedPriceYen', (price) => {
    return '¥' + Number(price).toLocaleString()
  })
}