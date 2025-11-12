import React from 'react';

const Articles = () => {
    return (
        <div className="bg-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="text-center mb-12">
                    <h1 className="text-4xl font-bold text-gray-900 mb-4">Articles</h1>
                    <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                        Explore our collection of in-depth articles on technology, development, and digital innovation.
                    </p>
                </div>
                
                <div className="text-center py-20">
                    <div className="text-6xl mb-4">📚</div>
                    <h2 className="text-2xl font-bold text-gray-900 mb-4">Coming Soon</h2>
                    <p className="text-gray-600">
                        We're preparing comprehensive articles for you. Stay tuned!
                    </p>
                </div>
            </div>
        </div>
    );
};

export default Articles;
