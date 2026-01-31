import React from 'react';

const ServicesLaravel = ({ isDarkMode }) => {
    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <section className={`py-16 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-4xl mx-auto text-center">
                    <h1 className={`text-4xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        Laravel Development
                    </h1>
                    <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        Custom Laravel development for scalable web apps, APIs, and backend systems.
                    </p>
                    <a href="/contact" className="inline-block mt-6 px-6 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                        Request a Quote
                    </a>
                </div>
            </section>

            <section className="py-12 px-4 sm:px-6 lg:px-8">
                <div className="max-w-5xl mx-auto grid md:grid-cols-2 gap-6">
                    <div className={`rounded-2xl p-6 border ${isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'}`}>
                        <h3 className={`text-xl font-semibold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            What’s Included
                        </h3>
                        <ul className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'} space-y-2`}>
                            <li>• Custom Laravel applications</li>
                            <li>• Authentication & authorization</li>
                            <li>• Optimized database queries</li>
                            <li>• Testing and deployment</li>
                        </ul>
                    </div>
                    <div className={`rounded-2xl p-6 border ${isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'}`}>
                        <h3 className={`text-xl font-semibold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            Best For
                        </h3>
                        <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                            Startups, SaaS platforms, and enterprise systems that need reliable backend architecture.
                        </p>
                        <a href="/hire-us" className="inline-block mt-4 text-indigo-500 hover:text-indigo-400">
                            Start a Project →
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};

export default ServicesLaravel;
