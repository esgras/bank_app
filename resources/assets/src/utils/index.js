exports.formatCardNumber = (number) => {
    return ('' + number).match(/\d{4}/g).join('-');
};