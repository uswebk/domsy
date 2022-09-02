export default {
  formattedPriceYen(price) {
    return '¥' + Number(price).toLocaleString()
  },
}
