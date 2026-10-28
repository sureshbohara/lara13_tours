import React from 'react';
import { Link } from '@inertiajs/react';

export default function Breadcrumb({ items }) {
    if (!items || items.length === 0) return null;

    return (
        <section className="bg-slate-50 border-b border-slate-200 py-4">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav aria-label="breadcrumb">
                    <ol className="flex flex-wrap items-center gap-2 text-sm list-none p-0 m-0">
                        {items.map((item, index) => {
                            const isLast = index === items.length - 1;
                            return (
                                <li key={index} className="flex items-center">
                                    {!isLast && item.href && (
                                        <>
                                            <Link href={item.href} className="text-slate-600 hover:text-blue-600 transition-colors font-medium">
                                                {item.label}
                                            </Link>
                                            <i className="fa-solid fa-chevron-right text-[10px] text-slate-400 mx-2"></i>
                                        </>
                                    )}
                                    {isLast && (
                                        <span className="text-slate-900 font-semibold" aria-current="page">{item.label}</span>
                                    )}
                                </li>
                            );
                        })}
                    </ol>
                </nav>
            </div>
        </section>
    );
}