import React, { createContext, useContext } from 'react';
import { useCurrency } from '../Hooks/useCurrency';

const CurrencyContext = createContext();

export function CurrencyProvider({ children }) {
    const currencyData = useCurrency();
    return (
        <CurrencyContext.Provider value={currencyData}>
            {children}
        </CurrencyContext.Provider>
    );
}

export const useCurrencyContext = () => useContext(CurrencyContext);