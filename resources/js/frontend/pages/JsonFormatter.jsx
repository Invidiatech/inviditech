import React, { useState, useEffect } from 'react';

const JsonFormatter = () => {
    const [jsonInput, setJsonInput] = useState('');
    const [jsonOutput, setJsonOutput] = useState('');
    const [statusMessage, setStatusMessage] = useState({ text: '', type: '' });
    const [inputError, setInputError] = useState(false);

    // Set page title and meta tags
    useEffect(() => {
        document.title = 'Free Online JSON Formatter & Validator Tool - InvidiaTech';
        
        // Update meta description
        let metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription) {
            metaDescription.content = 'Free online JSON formatter, validator, and beautifier tool. Format, validate, minify, and beautify JSON data instantly. Perfect for developers and API testing.';
        }
    }, []);

    const showMessage = (text, type) => {
        setStatusMessage({ text, type });
        setTimeout(() => setStatusMessage({ text: '', type: '' }), 4000);
    };

    const formatJSON = () => {
        const input = jsonInput.trim();
        
        if (!input) {
            showMessage('Please enter some JSON data to format', 'error');
            setInputError(true);
            return;
        }
        
        try {
            const parsed = JSON.parse(input);
            const formatted = JSON.stringify(parsed, null, 2);
            setJsonOutput(formatted);
            setInputError(false);
            showMessage('✓ JSON is valid and formatted successfully!', 'success');
        } catch (error) {
            setInputError(true);
            showMessage(`✗ Invalid JSON: ${error.message}`, 'error');
            setJsonOutput('');
        }
    };

    const minifyJSON = () => {
        const input = jsonInput.trim();
        
        if (!input) {
            showMessage('Please enter some JSON data to minify', 'error');
            return;
        }
        
        try {
            const parsed = JSON.parse(input);
            const minified = JSON.stringify(parsed);
            setJsonOutput(minified);
            setInputError(false);
            showMessage('✓ JSON minified successfully!', 'success');
        } catch (error) {
            setInputError(true);
            showMessage(`✗ Invalid JSON: ${error.message}`, 'error');
        }
    };

    const copyOutput = () => {
        if (!jsonOutput) {
            showMessage('No output to copy. Please format JSON first.', 'error');
            return;
        }
        
        navigator.clipboard.writeText(jsonOutput).then(() => {
            showMessage('✓ Copied to clipboard!', 'success');
        }).catch(() => {
            showMessage('✗ Failed to copy to clipboard', 'error');
        });
    };

    const clearAll = () => {
        setJsonInput('');
        setJsonOutput('');
        setInputError(false);
        showMessage('✓ Cleared all data', 'success');
    };

    const downloadJSON = () => {
        if (!jsonOutput) {
            showMessage('No output to download. Please format JSON first.', 'error');
            return;
        }
        
        const blob = new Blob([jsonOutput], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `formatted-${Date.now()}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        showMessage('✓ JSON file downloaded successfully!', 'success');
    };

    const handleKeyDown = (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            formatJSON();
        }
        
        if (e.key === 'Tab') {
            e.preventDefault();
            const start = e.target.selectionStart;
            const end = e.target.selectionEnd;
            const newValue = jsonInput.substring(0, start) + '  ' + jsonInput.substring(end);
            setJsonInput(newValue);
            setTimeout(() => {
                e.target.selectionStart = e.target.selectionEnd = start + 2;
            }, 0);
        }
    };

    return (
        <>
            <div className="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-purple-700 py-20 px-4 sm:px-6 lg:px-8">
                <div className="max-w-6xl mx-auto">
                    {/* Tool Card */}
                    <div className="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fadeInUp">
                        {/* Header */}
                        <div className="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-12 px-8 text-center">
                            <div className="flex items-center justify-center mb-4">
                                <i className="fas fa-code text-5xl"></i>
                            </div>
                            <h1 className="text-4xl md:text-5xl font-bold mb-4">JSON Formatter & Validator</h1>
                            <p className="text-xl text-indigo-100">Format, validate, beautify, and minify JSON data instantly</p>
                        </div>

                        {/* Tool Body */}
                        <div className="p-8 md:p-12">
                            {/* Status Message */}
                            {statusMessage.text && (
                                <div className={`p-4 rounded-xl mb-6 border-l-4 animate-slideIn ${
                                    statusMessage.type === 'success' 
                                        ? 'bg-green-50 text-green-800 border-green-500' 
                                        : 'bg-red-50 text-red-800 border-red-500'
                                }`}>
                                    {statusMessage.text}
                                </div>
                            )}

                            {/* Input Area */}
                            <div className="mb-6">
                                <div className="flex items-center justify-between mb-3">
                                    <label className="text-lg font-semibold text-gray-800 flex items-center">
                                        <i className="fas fa-keyboard mr-2"></i> Input JSON
                                    </label>
                                    <span className="text-sm text-gray-500">{jsonInput.length} characters</span>
                                </div>
                                <textarea
                                    value={jsonInput}
                                    onChange={(e) => setJsonInput(e.target.value)}
                                    onKeyDown={handleKeyDown}
                                    className={`w-full min-h-[300px] p-4 border-2 rounded-xl font-mono text-sm resize-y transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-200 ${
                                        inputError ? 'border-red-500' : 'border-gray-300 focus:border-indigo-500'
                                    }`}
                                    placeholder='Paste your JSON here, e.g., {"name":"John","age":30,"city":"New York"}'
                                    spellCheck="false"
                                />
                            </div>

                            {/* Action Buttons */}
                            <div className="flex flex-wrap gap-3 mb-6">
                                <button
                                    onClick={formatJSON}
                                    className="flex-1 min-w-[140px] bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-magic"></i> Format & Validate
                                </button>
                                <button
                                    onClick={minifyJSON}
                                    className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-compress"></i> Minify
                                </button>
                                <button
                                    onClick={copyOutput}
                                    className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-copy"></i> Copy
                                </button>
                                <button
                                    onClick={clearAll}
                                    className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-trash"></i> Clear
                                </button>
                                <button
                                    onClick={downloadJSON}
                                    className="flex-1 min-w-[140px] bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-download"></i> Download
                                </button>
                            </div>

                            {/* Output Area */}
                            <div>
                                <div className="flex items-center justify-between mb-3">
                                    <label className="text-lg font-semibold text-gray-800 flex items-center">
                                        <i className="fas fa-check-circle mr-2"></i> Output
                                    </label>
                                    <span className="text-sm text-gray-500">{jsonOutput.length} characters</span>
                                </div>
                                <textarea
                                    value={jsonOutput}
                                    readOnly
                                    className="w-full min-h-[300px] p-4 border-2 border-gray-300 rounded-xl font-mono text-sm bg-gray-50 resize-y"
                                    placeholder="Formatted JSON will appear here..."
                                    spellCheck="false"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Features Section */}
                    <div className="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
                        <h2 className="text-3xl font-bold text-gray-900 text-center mb-8">Powerful Features</h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {[
                                { icon: 'fa-check', title: 'Instant Validation', desc: 'Automatically validates JSON syntax and highlights errors' },
                                { icon: 'fa-paint-brush', title: 'Beautiful Formatting', desc: 'Formats JSON with proper indentation for readability' },
                                { icon: 'fa-compress-alt', title: 'Minification', desc: 'Compress JSON by removing whitespace and line breaks' },
                                { icon: 'fa-shield-alt', title: '100% Client-Side', desc: 'All processing happens in your browser - secure & private' },
                                { icon: 'fa-bolt', title: 'Lightning Fast', desc: 'Process large JSON files instantly without delays' },
                                { icon: 'fa-mobile-alt', title: 'Mobile Friendly', desc: 'Works perfectly on all devices - desktop, tablet, mobile' }
                            ].map((feature, index) => (
                                <div key={index} className="flex gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white">
                                        <i className={`fas ${feature.icon} text-xl`}></i>
                                    </div>
                                    <div>
                                        <h3 className="font-semibold text-gray-900 mb-1">{feature.title}</h3>
                                        <p className="text-sm text-gray-600">{feature.desc}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* SEO Content */}
                    <div className="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
                        <h2 className="text-3xl font-bold text-gray-900 mb-6">What is JSON Formatter & Validator?</h2>
                        <p className="text-gray-700 leading-relaxed mb-6">
                            JSON (JavaScript Object Notation) is a lightweight data-interchange format that's easy for humans to read and write, 
                            and easy for machines to parse and generate. Our free online JSON Formatter & Validator tool helps developers format, 
                            validate, beautify, and minify JSON data quickly and efficiently.
                        </p>
                        
                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Why Use Our JSON Formatter?</h3>
                        <p className="text-gray-700 leading-relaxed mb-4">
                            Whether you're debugging API responses, working with configuration files, or analyzing data structures, our JSON formatter 
                            provides essential functionality for daily development tasks:
                        </p>
                        <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                            <li><strong>Instant Validation:</strong> Quickly identify syntax errors in your JSON data</li>
                            <li><strong>Beautification:</strong> Transform minified JSON into readable, properly indented format</li>
                            <li><strong>Minification:</strong> Compress JSON for production use or API transmission</li>
                            <li><strong>Easy Copying:</strong> One-click copy to clipboard functionality</li>
                            <li><strong>File Download:</strong> Save formatted JSON as a .json file</li>
                            <li><strong>Privacy Focused:</strong> All processing happens in your browser - no data sent to servers</li>
                        </ul>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Common Use Cases</h3>
                        <ul className="list-disc list-inside text-gray-700 space-y-2">
                            <li>Debugging API responses and requests</li>
                            <li>Formatting configuration files (package.json, tsconfig.json, etc.)</li>
                            <li>Validating JSON data before processing</li>
                            <li>Converting between formatted and minified JSON</li>
                            <li>Learning JSON structure and syntax</li>
                            <li>Cleaning up messy JSON data from various sources</li>
                        </ul>
                    </div>
                </div>
            </div>
        </>
    );
};

export default JsonFormatter;
