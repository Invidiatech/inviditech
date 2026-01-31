import React, { useState, useEffect } from 'react';

const UrlEncoderDecoder = () => {
    const [input, setInput] = useState('');
    const [output, setOutput] = useState('');
    const [mode, setMode] = useState('encode');
    const [statusMessage, setStatusMessage] = useState({ text: '', type: '' });

    useEffect(() => {
        document.title = 'Free URL Encoder & Decoder - Online URL Encode/Decode Tool';
        let metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription) {
            metaDescription.content = 'Free online URL encoder and decoder tool. Encode or decode URLs, query strings, and special characters instantly. Perfect for API testing, web development, and SEO. No signup required.';
        }
    }, []);

    const showMessage = (text, type) => {
        setStatusMessage({ text, type });
        setTimeout(() => setStatusMessage({ text: '', type: '' }), 4000);
    };

    const handleConvert = () => {
        if (!input.trim()) {
            showMessage('Please enter text or URL to process', 'error');
            return;
        }

        try {
            if (mode === 'encode') {
                const encoded = encodeURIComponent(input);
                setOutput(encoded);
                showMessage('✓ URL encoded successfully!', 'success');
            } else {
                const decoded = decodeURIComponent(input);
                setOutput(decoded);
                showMessage('✓ URL decoded successfully!', 'success');
            }
        } catch (error) {
            showMessage('✗ Invalid input for decoding', 'error');
            setOutput('');
        }
    };

    const copyOutput = () => {
        if (!output) {
            showMessage('No output to copy', 'error');
            return;
        }
        navigator.clipboard.writeText(output).then(() => {
            showMessage('✓ Copied to clipboard!', 'success');
        });
    };

    const swap = () => {
        setInput(output);
        setOutput(input);
        setMode(mode === 'encode' ? 'decode' : 'encode');
        showMessage('✓ Input and output swapped!', 'success');
    };

    const clearAll = () => {
        setInput('');
        setOutput('');
        showMessage('✓ Cleared all data', 'success');
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-teal-600 via-cyan-600 to-blue-600 py-20 px-4 sm:px-6 lg:px-8">
            <div className="max-w-6xl mx-auto">
                <div className="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <div className="bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-12 px-8 text-center">
                        <div className="flex items-center justify-center mb-4">
                            <i className="fas fa-link text-5xl"></i>
                        </div>
                        <h1 className="text-4xl md:text-5xl font-bold mb-4">URL Encoder & Decoder</h1>
                        <p className="text-xl text-teal-100">Encode or decode URLs and query strings instantly</p>
                    </div>

                    <div className="p-8 md:p-12">
                        {statusMessage.text && (
                            <div className={`p-4 rounded-xl mb-6 border-l-4 ${statusMessage.type === 'success' ? 'bg-green-50 text-green-800 border-green-500' : 'bg-red-50 text-red-800 border-red-500'}`}>
                                {statusMessage.text}
                            </div>
                        )}

                        <div className="flex justify-center mb-8">
                            <div className="inline-flex rounded-xl border-2 border-gray-200 p-1 bg-gray-50">
                                <button onClick={() => setMode('encode')} className={`px-8 py-3 rounded-lg font-semibold transition-all ${mode === 'encode' ? 'bg-gradient-to-r from-teal-600 to-cyan-600 text-white shadow-lg' : 'text-gray-600'}`}>
                                    <i className="fas fa-arrow-right mr-2"></i> Encode
                                </button>
                                <button onClick={() => setMode('decode')} className={`px-8 py-3 rounded-lg font-semibold transition-all ${mode === 'decode' ? 'bg-gradient-to-r from-teal-600 to-cyan-600 text-white shadow-lg' : 'text-gray-600'}`}>
                                    <i className="fas fa-arrow-left mr-2"></i> Decode
                                </button>
                            </div>
                        </div>

                        <div className="mb-6">
                            <div className="flex items-center justify-between mb-3">
                                <label className="text-lg font-semibold text-gray-800">Input</label>
                                <span className="text-sm text-gray-500">{input.length} characters</span>
                            </div>
                            <textarea value={input} onChange={(e) => setInput(e.target.value)} className="w-full min-h-[200px] p-4 border-2 border-gray-300 rounded-xl text-sm resize-y focus:outline-none focus:ring-4 focus:ring-teal-200 focus:border-teal-500" placeholder={mode === 'encode' ? 'https://example.com/search?q=hello world' : 'https%3A%2F%2Fexample.com%2Fsearch%3Fq%3Dhello%20world'} />
                        </div>

                        <div className="flex flex-wrap gap-3 mb-6">
                            <button onClick={handleConvert} className="flex-1 min-w-[140px] bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white px-6 py-3 rounded-xl font-semibold transition-all hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i className="fas fa-exchange-alt"></i> {mode === 'encode' ? 'Encode URL' : 'Decode URL'}
                            </button>
                            <button onClick={swap} className="flex-1 min-w-[140px] bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-semibold transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i className="fas fa-sync"></i> Swap
                            </button>
                            <button onClick={copyOutput} className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i className="fas fa-copy"></i> Copy
                            </button>
                            <button onClick={clearAll} className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i className="fas fa-trash"></i> Clear
                            </button>
                        </div>

                        <div>
                            <div className="flex items-center justify-between mb-3">
                                <label className="text-lg font-semibold text-gray-800">Output</label>
                                <span className="text-sm text-gray-500">{output.length} characters</span>
                            </div>
                            <textarea value={output} readOnly className="w-full min-h-[200px] p-4 border-2 border-gray-300 rounded-xl text-sm bg-gray-50 resize-y" placeholder="Result will appear here..." />
                        </div>
                    </div>
                </div>

                {/* SEO Content */}
                <div className="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
                    <h2 className="text-3xl font-bold text-gray-900 mb-6">What is URL Encoding?</h2>
                    <p className="text-gray-700 leading-relaxed mb-6">
                        URL encoding (also called percent-encoding) converts characters into a format that can be safely transmitted over the internet. 
                        Special characters, spaces, and non-ASCII characters are replaced with a "%" followed by hexadecimal digits. 
                        Our free URL encoder/decoder tool makes it easy to encode or decode URLs, query parameters, and special characters instantly.
                    </p>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Common Use Cases</h3>
                    <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                        <li><strong>API Testing:</strong> Encode parameters before sending API requests</li>
                        <li><strong>URL Building:</strong> Create valid URLs with special characters</li>
                        <li><strong>Form Data:</strong> Encode form submissions for HTTP requests</li>
                        <li><strong>Query Strings:</strong> Build search queries with multiple parameters</li>
                        <li><strong>SEO Work:</strong> Create clean, encoded URLs for better SEO</li>
                        <li><strong>Debugging:</strong> Decode URLs to understand their structure</li>
                        <li><strong>Web Development:</strong> Handle user input with special characters</li>
                    </ul>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Characters That Need Encoding</h3>
                    <div className="bg-gray-50 rounded-xl p-6 mb-6">
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div><span className="font-mono bg-white px-2 py-1 rounded">Space → %20</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">! → %21</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded"># → %23</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">$ → %24</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">& → %26</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">' → %27</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">( → %28</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">) → %29</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">+ → %2B</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">, → %2C</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">/ → %2F</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">: → %3A</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">; → %3B</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">= → %3D</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">? → %3F</span></div>
                            <div><span className="font-mono bg-white px-2 py-1 rounded">@ → %40</span></div>
                        </div>
                    </div>

                    <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Best Practices</h3>
                    <ul className="list-disc list-inside text-gray-700 space-y-2">
                        <li>Always encode user input before adding it to URLs</li>
                        <li>Encode query parameters separately, not the entire URL</li>
                        <li>Use encodeURIComponent() for parameter values</li>
                        <li>Don't double-encode already encoded URLs</li>
                        <li>Remember that + can mean space in query strings</li>
                        <li>Test encoded URLs before using them in production</li>
                    </ul>
                </div>
            </div>
        </div>
    );
};

export default UrlEncoderDecoder;
