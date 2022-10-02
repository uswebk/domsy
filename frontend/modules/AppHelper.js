export default ({ app }, inject) => {
  inject('formattedPriceYen', (price) => {
    return '¥' + Number(price).toLocaleString()
  })
  inject('getEmoji', () => {
    const emojiCode =
      Math.random(10) * 10 > 7.75
        ? Math.floor(random(128512, 128592))
        : Math.floor(random(127744, 128318))

    return String.fromCodePoint(emojiCode)
  })
  function random(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min
  }
}
