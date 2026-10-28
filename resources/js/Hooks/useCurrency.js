import { useState, useEffect } from 'react';
import { CURRENCIES } from '../Utils/constants';

export function useCurrency() {
    const [currency, setCurrencyState] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('selectedCurrency') || 'NPR';
        }
        return 'NPR';
    });

    useEffect(() => {
        localStorage.setItem('selectedCurrency', currency);
    }, [currency]);

    const setCurrency = (newCurrency) => {
        if (CURRENCIES[newCurrency]) {
            setCurrencyState(newCurrency);
        }
    };

    const convertPrice = (price, fromCurrency = 'NPR') => {
        if (!price) return 0;
        const priceInNPR = price / CURRENCIES[fromCurrency].rate;
        return priceInNPR * CURRENCIES[currency].rate;
    };

    const formatPrice = (price) => {
        const converted = convertPrice(price);
        return `${CURRENCIES[currency].symbol}${converted.toLocaleString('en-US', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2,
        })}`;
    };

    return { currency, setCurrency, convertPrice, formatPrice };
}