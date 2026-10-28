import React, { useState } from 'react';

export default function GalleryItem({ image, title }) {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <>
            <div
                onClick={() => setIsOpen(true)}
                className="group relative overflow-hidden rounded-2xl cursor-pointer aspect-square shadow-md hover:shadow-xl transition-all duration-300"
            >
                <img
                    src={`/images/${image}`}
                    alt={title}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                    <i className="fa-solid fa-expand text-white text-2xl"></i>
                </div>
            </div>

            {isOpen && (
                <div
                    onClick={() => setIsOpen(false)}
                    className="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4 cursor-zoom-out"
                >
                    <img
                        src={`/images/${image}`}
                        alt={title}
                        className="max-w-full max-h-full object-contain rounded-lg"
                    />
                    <button className="absolute top-4 right-4 text-white text-3xl hover:text-blue-400">
                        <i className="fa-solid fa-xmark"></i>
                    </button>
                </div>
            )}
        </>
    );
}