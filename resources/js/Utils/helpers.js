export const formatPrice = (price, currency = 'NPR') => {
    const symbols = {
        NPR: 'Rs ',
        USD: '$',
        EUR: '€',
        INR: '₹',
    };
    return `${symbols[currency] || ''}${parseFloat(price || 0).toLocaleString('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    })}`;
};

export const truncateText = (text, length = 100) => {
    if (!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
};

export const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};