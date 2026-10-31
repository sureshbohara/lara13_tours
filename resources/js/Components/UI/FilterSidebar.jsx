import React from 'react';

export default function FilterSidebar({ category, subCategories, packages, filters, onFilterChange }) {
    
    const handleReset = () => {
        onFilterChange('reset', null);
    };


    const toggleFilter = (key, value) => {

        const newValue = filters[key] === value ? '' : value;
        onFilterChange(key, newValue);
    };

    return (
        <div className="filter-sidebar" id="filterSidebar">
            {/* Search (UI Only for now) */}
            <div className="filter-group">
                <h5 className="filter-title"><i className="bi bi-search"></i> Search Trip</h5>
                <div className="filter-search">
                    <i className="bi bi-search"></i>
                    <input type="text" placeholder="e.g., Everest, 10 days..." />
                </div>
            </div>

         
            {subCategories.length > 0 && (
                <div className="filter-group">
                    <h5 className="filter-title"><i className="bi bi-geo-alt"></i> {category.name} Regions</h5>
                    <label className={`filter-checkbox ${!filters.subcategory ? 'active-filter' : ''}`} onClick={() => onFilterChange('subcategory', '')} style={{ cursor: 'pointer' }}>
                        <input type="radio" name="subcategory" checked={!filters.subcategory} readOnly /> 
                        All {category.name} <span className="filter-count">{packages.total}</span>
                    </label>
                    {subCategories.map((sub) => (
                        <label key={sub.id} className={`filter-checkbox ${filters.subcategory == sub.id ? 'active-filter' : ''}`} onClick={() => onFilterChange('subcategory', sub.id)} style={{ cursor: 'pointer' }}>
                            <input type="radio" name="subcategory" checked={filters.subcategory == sub.id} readOnly /> 
                            {sub.name} <span className="filter-count">{sub.packages_count}</span>
                        </label>
                    ))}
                </div>
            )}

          
            <div className="filter-group">
                <h5 className="filter-title"><i className="bi bi-clock-history"></i> Duration</h5>
                {[
                    { label: '1 - 5 Days', value: '1-5' },
                    { label: '6 - 10 Days', value: '6-10' },
                    { label: '11 - 15 Days', value: '11-15' },
                    { label: '16+ Days', value: '16+' }
                ].map((opt) => (
                    <label key={opt.value} className="filter-checkbox" style={{ cursor: 'pointer' }}>
                        <input 
                            type="checkbox" 
                            checked={filters.duration === opt.value}
                            onChange={() => toggleFilter('duration', opt.value)}
                        /> 
                        {opt.label}
                    </label>
                ))}
            </div>

    
            <div className="filter-group">
                <h5 className="filter-title"><i className="bi bi-signpost-2"></i> Difficulty Level</h5>
                {[
                    { label: 'Easy / Leisure', value: 'Easy' },
                    { label: 'Moderate', value: 'Moderate' },
                    { label: 'Strenuous', value: 'Strenuous' },
                    { label: 'Challenging', value: 'Challenging' }
                ].map((opt) => (
                    <label key={opt.value} className="filter-checkbox" style={{ cursor: 'pointer' }}>
                        <input 
                            type="checkbox" 
                            checked={filters.difficulty === opt.value}
                            onChange={() => toggleFilter('difficulty', opt.value)}
                        /> 
                        {opt.label}
                    </label>
                ))}
            </div>

            {/* Reset Button */}
            <button className="btn-reset-filter" onClick={handleReset}>
                <i className="bi bi-arrow-counterclockwise"></i> Reset All Filters
            </button>
        </div>
    );
}