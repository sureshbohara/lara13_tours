import React from 'react';

export default function TeamCard({ member }) {
    return (
        <div className="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-all duration-300 group text-center">
            <div className="relative overflow-hidden aspect-square">
                <img
                    src={`/images/${member.image}`}
                    alt={member.name}
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                />
            </div>
            <div className="p-5">
                <h3 className="text-lg font-bold text-slate-900 mb-1">{member.name}</h3>
                {member.bio && <p className="text-sm text-slate-500 mb-3 line-clamp-2">{member.bio}</p>}
                
                <div className="flex justify-center gap-2">
                    {member.facebook && (
                        <a href={member.facebook} target="_blank" rel="noopener noreferrer" className="w-8 h-8 bg-slate-100 hover:bg-blue-600 hover:text-white rounded-full flex items-center justify-center transition-colors">
                            <i className="fa-brands fa-facebook-f text-sm"></i>
                        </a>
                    )}
                    {member.instagram && (
                        <a href={member.instagram} target="_blank" rel="noopener noreferrer" className="w-8 h-8 bg-slate-100 hover:bg-pink-600 hover:text-white rounded-full flex items-center justify-center transition-colors">
                            <i className="fa-brands fa-instagram text-sm"></i>
                        </a>
                    )}
                </div>
            </div>
        </div>
    );
}