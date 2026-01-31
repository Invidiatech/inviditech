import React, { useState, useEffect } from 'react';

const Base64Tool = () => {
    const [input, setInput] = useState('');
    const [output, setOutput] = useState('');
    const [mode, setMode] = useState('encode'); // 'encode' or 'decode'
    const [statusMessage, setStatusMessage] = useState({ text: '', type: '' });

    // Set page title and meta tags
    useEffect(() => {
        document.title = 'Free Base64 Encoder & Decoder Tool - Online Base64 Converter - InvidiaTech';
        
        // Update meta description
        let metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription) {
            metaDescription.content = 'Free online Base64 encoder and decoder tool. Encode text to Base64 or decode Base64 to text instantly. Perfect for developers, data encoding, and API testing.';
        }
    }, []);

    const showMessage = (text, type) => {
        setStatusMessage({ text, type });
        setTimeout(() => setStatusMessage({ text: '', type: '' }), 4000);
    };

    const encodeBase64 = () => {
        const text = input.trim();
        
        if (!text) {
            showMessage('Please enter some text to encode', 'error');
            return;
        }
        
        try {
            const encoded = btoa(unescape(encodeURIComponent(text)));
            setOutput(encoded);
            showMessage('✓ Text encoded to Base64 successfully!', 'success');
        } catch (error) {
            showMessage(`✗ Encoding failed: ${error.message}`, 'error');
            setOutput('');
        }
    };

    const decodeBase64 = () => {
        const text = input.trim();
        
        if (!text) {
            showMessage('Please enter Base64 string to decode', 'error');
            return;
        }
        
        try {
            const decoded = decodeURIComponent(escape(atob(text)));
            setOutput(decoded);
            showMessage('✓ Base64 decoded successfully!', 'success');
        } catch (error) {
            showMessage('✗ Invalid Base64 string. Please check your input.', 'error');
            setOutput('');
        }
    };

    const handleConvert = () => {
        if (mode === 'encode') {
            encodeBase64();
        } else {
            decodeBase64();
        }
    };

    const copyOutput = () => {
        if (!output) {
            showMessage('No output to copy. Please encode/decode first.', 'error');
            return;
        }
        
        navigator.clipboard.writeText(output).then(() => {
            showMessage('✓ Copied to clipboard!', 'success');
        }).catch(() => {
            showMessage('✗ Failed to copy to clipboard', 'error');
        });
    };

    const clearAll = () => {
        setInput('');
        setOutput('');
        showMessage('✓ Cleared all data', 'success');
    };

    const downloadOutput = () => {
        if (!output) {
            showMessage('No output to download. Please encode/decode first.', 'error');
            return;
        }
        
        const blob = new Blob([output], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `base64-${mode}-${Date.now()}.txt`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        
        showMessage('✓ File downloaded successfully!', 'success');
    };

    const swapInputOutput = () => {
        if (!output) {
            showMessage('No output to swap', 'error');
            return;
        }
        setInput(output);
        setOutput(input);
        setMode(mode === 'encode' ? 'decode' : 'encode');
        showMessage('✓ Input and output swapped!', 'success');
    };

    const handleFileUpload = (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (event) => {
            setInput(event.target.result);
            showMessage('✓ File loaded successfully!', 'success');
        };
        reader.onerror = () => {
            showMessage('✗ Failed to read file', 'error');
        };
        reader.readAsText(file);
    };

    return (
        <>
            <div className="min-h-screen bg-gradient-to-br from-blue-600 via-cyan-600 to-teal-600 py-20 px-4 sm:px-6 lg:px-8">
                <div className="max-w-6xl mx-auto">
                    {/* Tool Card */}
                    <div className="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fadeInUp">
                        {/* Header */}
                        <div className="bg-gradient-to-r from-blue-600 to-cyan-600 text-white py-12 px-8 text-center">
                            <div className="flex items-center justify-center mb-4">
                                <i className="fas fa-lock text-5xl"></i>
                            </div>
                            <h1 className="text-4xl md:text-5xl font-bold mb-4">Base64 Encoder & Decoder</h1>
                            <p className="text-xl text-blue-100">Encode or decode Base64 strings instantly and securely</p>
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

                            {/* Mode Toggle */}
                            <div className="flex justify-center mb-8">
                                <div className="inline-flex rounded-xl border-2 border-gray-200 p-1 bg-gray-50">
                                    <button
                                        onClick={() => setMode('encode')}
                                        className={`px-8 py-3 rounded-lg font-semibold transition-all duration-200 ${
                                            mode === 'encode'
                                                ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg'
                                                : 'text-gray-600 hover:text-gray-800'
                                        }`}
                                    >
                                        <i className="fas fa-lock mr-2"></i> Encode
                                    </button>
                                    <button
                                        onClick={() => setMode('decode')}
                                        className={`px-8 py-3 rounded-lg font-semibold transition-all duration-200 ${
                                            mode === 'decode'
                                                ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg'
                                                : 'text-gray-600 hover:text-gray-800'
                                        }`}
                                    >
                                        <i className="fas fa-unlock mr-2"></i> Decode
                                    </button>
                                </div>
                            </div>

                            {/* Input Area */}
                            <div className="mb-6">
                                <div className="flex items-center justify-between mb-3">
                                    <label className="text-lg font-semibold text-gray-800 flex items-center">
                                        <i className="fas fa-keyboard mr-2"></i> 
                                        {mode === 'encode' ? 'Text to Encode' : 'Base64 String to Decode'}
                                    </label>
                                    <div className="flex items-center gap-3">
                                        <label className="cursor-pointer text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                            <i className="fas fa-file-upload"></i>
                                            <span>Upload File</span>
                                            <input
                                                type="file"
                                                accept=".txt,.json,.xml,.csv"
                                                onChange={handleFileUpload}
                                                className="hidden"
                                            />
                                        </label>
                                        <span className="text-sm text-gray-500">{input.length} characters</span>
                                    </div>
                                </div>
                                <textarea
                                    value={input}
                                    onChange={(e) => setInput(e.target.value)}
                                    className="w-full min-h-[300px] p-4 border-2 border-gray-300 rounded-xl font-mono text-sm resize-y transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500"
                                    placeholder={mode === 'encode' ? 'Enter text to encode...' : 'Enter Base64 string to decode...'}
                                    spellCheck="false"
                                />
                            </div>

                            {/* Action Buttons */}
                            <div className="flex flex-wrap gap-3 mb-6">
                                <button
                                    onClick={handleConvert}
                                    className="flex-1 min-w-[140px] bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className={`fas ${mode === 'encode' ? 'fa-lock' : 'fa-unlock'}`}></i>
                                    {mode === 'encode' ? 'Encode to Base64' : 'Decode from Base64'}
                                </button>
                                <button
                                    onClick={swapInputOutput}
                                    className="flex-1 min-w-[140px] bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-exchange-alt"></i> Swap
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
                                    onClick={downloadOutput}
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
                                    <span className="text-sm text-gray-500">{output.length} characters</span>
                                </div>
                                <textarea
                                    value={output}
                                    readOnly
                                    className="w-full min-h-[300px] p-4 border-2 border-gray-300 rounded-xl font-mono text-sm bg-gray-50 resize-y"
                                    placeholder="Result will appear here..."
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
                                { icon: 'fa-lock', title: 'Encode & Decode', desc: 'Convert text to Base64 and vice versa instantly' },
                                { icon: 'fa-file-upload', title: 'File Upload', desc: 'Upload text files to encode or decode directly' },
                                { icon: 'fa-exchange-alt', title: 'Quick Swap', desc: 'Swap input and output with one click' },
                                { icon: 'fa-shield-alt', title: '100% Client-Side', desc: 'All processing in your browser - secure & private' },
                                { icon: 'fa-bolt', title: 'Instant Results', desc: 'Process data immediately without delays' },
                                { icon: 'fa-mobile-alt', title: 'Mobile Friendly', desc: 'Works on all devices - desktop, tablet, mobile' }
                            ].map((feature, index) => (
                                <div key={index} className="flex gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center text-white">
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
                        <h2 className="text-3xl font-bold text-gray-900 mb-6">What is Base64 Encoding?</h2>
                        <p className="text-gray-700 leading-relaxed mb-6">
                            Base64 is a binary-to-text encoding scheme that represents binary data in an ASCII string format. 
                            It's commonly used to encode data that needs to be stored or transferred over media designed to handle text. 
                            Our free Base64 encoder and decoder tool makes it easy to convert between plain text and Base64 format.
                        </p>
                        
                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Why Use Base64 Encoding?</h3>
                        <p className="text-gray-700 leading-relaxed mb-4">
                            Base64 encoding is essential for various development scenarios:
                        </p>
                        <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                            <li><strong>Data Transfer:</strong> Safely transfer binary data over text-based protocols like HTTP, SMTP, and JSON</li>
                            <li><strong>Embedding Data:</strong> Include images or files directly in HTML, CSS, or JSON</li>
                            <li><strong>API Authentication:</strong> Encode credentials for Basic Authentication</li>
                            <li><strong>Data Storage:</strong> Store binary data in text-based formats like JSON or XML</li>
                            <li><strong>Email Attachments:</strong> Encode file attachments in emails</li>
                            <li><strong>URL Parameters:</strong> Pass binary data in URLs safely</li>
                        </ul>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Common Use Cases</h3>
                        <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                            <li>Encoding images for data URIs in CSS or HTML</li>
                            <li>API authentication with Basic Auth headers</li>
                            <li>Storing binary data in databases as text</li>
                            <li>Encoding JSON data for URL parameters</li>
                            <li>Email attachment encoding</li>
                            <li>JWT token payload encoding</li>
                            <li>Configuration file data encoding</li>
                        </ul>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">How to Use the Base64 Tool</h3>
                        <ol className="list-decimal list-inside text-gray-700 space-y-2 mb-6">
                            <li>Select whether you want to <strong>Encode</strong> or <strong>Decode</strong></li>
                            <li>Paste your text or Base64 string into the input area</li>
                            <li>Click the conversion button to process your data</li>
                            <li>Copy the result or download it as a file</li>
                            <li>Use the Swap button to quickly reverse the operation</li>
                        </ol>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Base64 Encoding Best Practices</h3>
                        <ul className="list-disc list-inside text-gray-700 space-y-2">
                            <li>Base64 is encoding, not encryption - don't use it for security</li>
                            <li>Base64 encoded data is about 33% larger than the original</li>
                            <li>Use URL-safe Base64 for data in URLs (handles +, /, = differently)</li>
                            <li>Always validate decoded data before using it</li>
                            <li>Consider compression before encoding large data</li>
                        </ul>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Base64Tool;
