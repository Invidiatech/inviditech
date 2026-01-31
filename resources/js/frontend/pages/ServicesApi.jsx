import React from 'react';

const ServicesApi = ({ isDarkMode }) => {
    return (
        <div className={`min-h-screen ${isDarkMode ? 'bg-gray-900' : 'bg-gray-50'}`}>
            <section className={`py-16 px-4 sm:px-6 lg:px-8 ${isDarkMode ? 'bg-gray-800' : 'bg-white'}`}>
                <div className="max-w-4xl mx-auto text-center">
                    <h1 className={`text-4xl font-bold mb-4 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                        API Development
                    </h1>
                    <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                        Secure REST APIs engineered for performance and easy integrations.
                    </p>
                    <a href="/contact" className="inline-block mt-6 px-6 py-3 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">
                        Discuss Your API
                    </a>
                </div>
            </section>

            <section className="py-12 px-4 sm:px-6 lg:px-8">
                <div className="max-w-5xl mx-auto grid md:grid-cols-2 gap-6">
                    <div className={`rounded-2xl p-6 border ${isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'}`}>
                        <h3 className={`text-xl font-semibold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            Deliverables
                        </h3>
                        <ul className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'} space-y-2`}>
                            <li>• RESTful API design</li>
                            <li>• OAuth/JWT authentication</li>
                            <li>• Rate limiting & logging</li>
                            <li>• API documentation</li>
                        </ul>
                    </div>
                    <div className={`rounded-2xl p-6 border ${isDarkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'}`}>
                        <h3 className={`text-xl font-semibold mb-3 ${isDarkMode ? 'text-white' : 'text-gray-900'}`}>
                            Use Cases
                        </h3>
                        <p className={`${isDarkMode ? 'text-gray-300' : 'text-gray-600'}`}>
                            Mobile apps, third‑party integrations, and backend services that need reliable data exchange.
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

export default ServicesApi;
