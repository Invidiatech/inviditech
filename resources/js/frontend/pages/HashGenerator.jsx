import React, { useState, useEffect } from 'react';

const HashGenerator = () => {
    const [input, setInput] = useState('');
    const [hashes, setHashes] = useState({
        md5: '',
        sha1: '',
        sha256: '',
        sha512: ''
    });
    const [statusMessage, setStatusMessage] = useState({ text: '', type: '' });

    useEffect(() => {
        document.title = 'Free Hash Generator - MD5, SHA1, SHA256, SHA512 Online Tool';
        let metaDescription = document.querySelector('meta[name="description"]');
        if (metaDescription) {
            metaDescription.content = 'Free online hash generator tool. Generate MD5, SHA-1, SHA-256, SHA-512 hashes instantly. Perfect for password hashing, file verification, and data integrity checks. No signup required.';
        }
    }, []);

    const showMessage = (text, type) => {
        setStatusMessage({ text, type });
        setTimeout(() => setStatusMessage({ text: '', type: '' }), 4000);
    };

    const generateHashes = async () => {
        if (!input.trim()) {
            showMessage('Please enter text to generate hashes', 'error');
            return;
        }

        try {
            const encoder = new TextEncoder();
            const data = encoder.encode(input);

            // Generate different hashes
            const md5Hash = await generateMD5(input);
            const sha1Hash = await crypto.subtle.digest('SHA-1', data);
            const sha256Hash = await crypto.subtle.digest('SHA-256', data);
            const sha512Hash = await crypto.subtle.digest('SHA-512', data);

            setHashes({
                md5: md5Hash,
                sha1: bufferToHex(sha1Hash),
                sha256: bufferToHex(sha256Hash),
                sha512: bufferToHex(sha512Hash)
            });

            showMessage('✓ Hashes generated successfully!', 'success');
        } catch (error) {
            showMessage('✗ Error generating hashes', 'error');
        }
    };

    // MD5 implementation (Web Crypto API doesn't support MD5)
    const generateMD5 = (string) => {
        // Simple MD5 implementation using a third-party algorithm
        const md5 = (string) => {
            function rotateLeft(value, shift) {
                return (value << shift) | (value >>> (32 - shift));
            }
            function addUnsigned(x, y) {
                const lsw = (x & 0xFFFF) + (y & 0xFFFF);
                const msw = (x >> 16) + (y >> 16) + (lsw >> 16);
                return (msw << 16) | (lsw & 0xFFFF);
            }
            function md5cmn(q, a, b, x, s, t) {
                return addUnsigned(rotateLeft(addUnsigned(addUnsigned(a, q), addUnsigned(x, t)), s), b);
            }
            function md5ff(a, b, c, d, x, s, t) {
                return md5cmn((b & c) | ((~b) & d), a, b, x, s, t);
            }
            function md5gg(a, b, c, d, x, s, t) {
                return md5cmn((b & d) | (c & (~d)), a, b, x, s, t);
            }
            function md5hh(a, b, c, d, x, s, t) {
                return md5cmn(b ^ c ^ d, a, b, x, s, t);
            }
            function md5ii(a, b, c, d, x, s, t) {
                return md5cmn(c ^ (b | (~d)), a, b, x, s, t);
            }
            function convertToWordArray(string) {
                let wordArray = [];
                for (let i = 0; i < string.length * 8; i += 8) {
                    wordArray[i >> 5] |= (string.charCodeAt(i / 8) & 0xFF) << (i % 32);
                }
                return wordArray;
            }
            function wordToHex(value) {
                let hex = '';
                for (let i = 0; i < 4; i++) {
                    hex += ((value >> (i * 8 + 4)) & 0x0F).toString(16) + ((value >> (i * 8)) & 0x0F).toString(16);
                }
                return hex;
            }
            
            const x = convertToWordArray(string);
            let a = 0x67452301;
            let b = 0xEFCDAB89;
            let c = 0x98BADCFE;
            let d = 0x10325476;
            
            x[string.length * 8 >> 5] |= 0x80 << ((string.length * 8) % 32);
            x[(((string.length * 8 + 64) >>> 9) << 4) + 14] = string.length * 8;
            
            for (let i = 0; i < x.length; i += 16) {
                const oldA = a, oldB = b, oldC = c, oldD = d;
                a = md5ff(a, b, c, d, x[i], 7, 0xD76AA478);
                d = md5ff(d, a, b, c, x[i + 1], 12, 0xE8C7B756);
                c = md5ff(c, d, a, b, x[i + 2], 17, 0x242070DB);
                b = md5ff(b, c, d, a, x[i + 3], 22, 0xC1BDCEEE);
                a = md5ff(a, b, c, d, x[i + 4], 7, 0xF57C0FAF);
                d = md5ff(d, a, b, c, x[i + 5], 12, 0x4787C62A);
                c = md5ff(c, d, a, b, x[i + 6], 17, 0xA8304613);
                b = md5ff(b, c, d, a, x[i + 7], 22, 0xFD469501);
                a = md5ff(a, b, c, d, x[i + 8], 7, 0x698098D8);
                d = md5ff(d, a, b, c, x[i + 9], 12, 0x8B44F7AF);
                c = md5ff(c, d, a, b, x[i + 10], 17, 0xFFFF5BB1);
                b = md5ff(b, c, d, a, x[i + 11], 22, 0x895CD7BE);
                a = md5ff(a, b, c, d, x[i + 12], 7, 0x6B901122);
                d = md5ff(d, a, b, c, x[i + 13], 12, 0xFD987193);
                c = md5ff(c, d, a, b, x[i + 14], 17, 0xA679438E);
                b = md5ff(b, c, d, a, x[i + 15], 22, 0x49B40821);
                a = md5gg(a, b, c, d, x[i + 1], 5, 0xF61E2562);
                d = md5gg(d, a, b, c, x[i + 6], 9, 0xC040B340);
                c = md5gg(c, d, a, b, x[i + 11], 14, 0x265E5A51);
                b = md5gg(b, c, d, a, x[i], 20, 0xE9B6C7AA);
                a = md5gg(a, b, c, d, x[i + 5], 5, 0xD62F105D);
                d = md5gg(d, a, b, c, x[i + 10], 9, 0x02441453);
                c = md5gg(c, d, a, b, x[i + 15], 14, 0xD8A1E681);
                b = md5gg(b, c, d, a, x[i + 4], 20, 0xE7D3FBC8);
                a = md5gg(a, b, c, d, x[i + 9], 5, 0x21E1CDE6);
                d = md5gg(d, a, b, c, x[i + 14], 9, 0xC33707D6);
                c = md5gg(c, d, a, b, x[i + 3], 14, 0xF4D50D87);
                b = md5gg(b, c, d, a, x[i + 8], 20, 0x455A14ED);
                a = md5gg(a, b, c, d, x[i + 13], 5, 0xA9E3E905);
                d = md5gg(d, a, b, c, x[i + 2], 9, 0xFCEFA3F8);
                c = md5gg(c, d, a, b, x[i + 7], 14, 0x676F02D9);
                b = md5gg(b, c, d, a, x[i + 12], 20, 0x8D2A4C8A);
                a = md5hh(a, b, c, d, x[i + 5], 4, 0xFFFA3942);
                d = md5hh(d, a, b, c, x[i + 8], 11, 0x8771F681);
                c = md5hh(c, d, a, b, x[i + 11], 16, 0x6D9D6122);
                b = md5hh(b, c, d, a, x[i + 14], 23, 0xFDE5380C);
                a = md5hh(a, b, c, d, x[i + 1], 4, 0xA4BEEA44);
                d = md5hh(d, a, b, c, x[i + 4], 11, 0x4BDECFA9);
                c = md5hh(c, d, a, b, x[i + 7], 16, 0xF6BB4B60);
                b = md5hh(b, c, d, a, x[i + 10], 23, 0xBEBFBC70);
                a = md5hh(a, b, c, d, x[i + 13], 4, 0x289B7EC6);
                d = md5hh(d, a, b, c, x[i], 11, 0xEAA127FA);
                c = md5hh(c, d, a, b, x[i + 3], 16, 0xD4EF3085);
                b = md5hh(b, c, d, a, x[i + 6], 23, 0x04881D05);
                a = md5hh(a, b, c, d, x[i + 9], 4, 0xD9D4D039);
                d = md5hh(d, a, b, c, x[i + 12], 11, 0xE6DB99E5);
                c = md5hh(c, d, a, b, x[i + 15], 16, 0x1FA27CF8);
                b = md5hh(b, c, d, a, x[i + 2], 23, 0xC4AC5665);
                a = md5ii(a, b, c, d, x[i], 6, 0xF4292244);
                d = md5ii(d, a, b, c, x[i + 7], 10, 0x432AFF97);
                c = md5ii(c, d, a, b, x[i + 14], 15, 0xAB9423A7);
                b = md5ii(b, c, d, a, x[i + 5], 21, 0xFC93A039);
                a = md5ii(a, b, c, d, x[i + 12], 6, 0x655B59C3);
                d = md5ii(d, a, b, c, x[i + 3], 10, 0x8F0CCC92);
                c = md5ii(c, d, a, b, x[i + 10], 15, 0xFFEFF47D);
                b = md5ii(b, c, d, a, x[i + 1], 21, 0x85845DD1);
                a = md5ii(a, b, c, d, x[i + 8], 6, 0x6FA87E4F);
                d = md5ii(d, a, b, c, x[i + 15], 10, 0xFE2CE6E0);
                c = md5ii(c, d, a, b, x[i + 6], 15, 0xA3014314);
                b = md5ii(b, c, d, a, x[i + 13], 21, 0x4E0811A1);
                a = md5ii(a, b, c, d, x[i + 4], 6, 0xF7537E82);
                d = md5ii(d, a, b, c, x[i + 11], 10, 0xBD3AF235);
                c = md5ii(c, d, a, b, x[i + 2], 15, 0x2AD7D2BB);
                b = md5ii(b, c, d, a, x[i + 9], 21, 0xEB86D391);
                a = addUnsigned(a, oldA);
                b = addUnsigned(b, oldB);
                c = addUnsigned(c, oldC);
                d = addUnsigned(d, oldD);
            }
            return (wordToHex(a) + wordToHex(b) + wordToHex(c) + wordToHex(d)).toLowerCase();
        };
        return md5(string);
    };

    const bufferToHex = (buffer) => {
        return Array.from(new Uint8Array(buffer))
            .map(b => b.toString(16).padStart(2, '0'))
            .join('');
    };

    const copyHash = (hash, type) => {
        if (!hash) {
            showMessage('No hash to copy. Please generate hashes first.', 'error');
            return;
        }
        navigator.clipboard.writeText(hash).then(() => {
            showMessage(`✓ ${type} hash copied to clipboard!`, 'success');
        });
    };

    const clearAll = () => {
        setInput('');
        setHashes({ md5: '', sha1: '', sha256: '', sha512: '' });
        showMessage('✓ Cleared all data', 'success');
    };

    return (
        <>
            <div className="min-h-screen bg-gradient-to-br from-orange-600 via-red-600 to-pink-600 py-20 px-4 sm:px-6 lg:px-8">
                <div className="max-w-6xl mx-auto">
                    {/* Tool Card */}
                    <div className="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fadeInUp">
                        {/* Header */}
                        <div className="bg-gradient-to-r from-orange-600 to-red-600 text-white py-12 px-8 text-center">
                            <div className="flex items-center justify-center mb-4">
                                <i className="fas fa-hashtag text-5xl"></i>
                            </div>
                            <h1 className="text-4xl md:text-5xl font-bold mb-4">Hash Generator</h1>
                            <p className="text-xl text-orange-100">Generate MD5, SHA-1, SHA-256, and SHA-512 hashes instantly</p>
                        </div>

                        {/* Tool Body */}
                        <div className="p-8 md:p-12">
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
                                        <i className="fas fa-keyboard mr-2"></i> Input Text
                                    </label>
                                    <span className="text-sm text-gray-500">{input.length} characters</span>
                                </div>
                                <textarea
                                    value={input}
                                    onChange={(e) => setInput(e.target.value)}
                                    className="w-full min-h-[200px] p-4 border-2 border-gray-300 rounded-xl font-mono text-sm resize-y transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-orange-500"
                                    placeholder="Enter text to generate hashes..."
                                    spellCheck="false"
                                />
                            </div>

                            {/* Action Buttons */}
                            <div className="flex flex-wrap gap-3 mb-8">
                                <button
                                    onClick={generateHashes}
                                    className="flex-1 min-w-[200px] bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-bolt"></i> Generate All Hashes
                                </button>
                                <button
                                    onClick={clearAll}
                                    className="flex-1 min-w-[140px] bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all duration-200 hover:-translate-y-0.5 flex items-center justify-center gap-2"
                                >
                                    <i className="fas fa-trash"></i> Clear
                                </button>
                            </div>

                            {/* Hash Results */}
                            <div className="space-y-4">
                                {[
                                    { type: 'MD5', value: hashes.md5, color: 'blue', icon: 'fa-shield-alt' },
                                    { type: 'SHA-1', value: hashes.sha1, color: 'green', icon: 'fa-lock' },
                                    { type: 'SHA-256', value: hashes.sha256, color: 'purple', icon: 'fa-key' },
                                    { type: 'SHA-512', value: hashes.sha512, color: 'pink', icon: 'fa-fingerprint' }
                                ].map((hash, index) => (
                                    <div key={index} className="border-2 border-gray-200 rounded-xl p-4">
                                        <div className="flex items-center justify-between mb-2">
                                            <div className="flex items-center gap-2">
                                                <i className={`fas ${hash.icon} text-${hash.color}-600`}></i>
                                                <span className="font-semibold text-gray-800">{hash.type}</span>
                                                {hash.value && (
                                                    <span className="text-xs text-gray-500">({hash.value.length} chars)</span>
                                                )}
                                            </div>
                                            <button
                                                onClick={() => copyHash(hash.value, hash.type)}
                                                className={`px-4 py-2 bg-${hash.color}-100 hover:bg-${hash.color}-200 text-${hash.color}-700 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2`}
                                            >
                                                <i className="fas fa-copy"></i> Copy
                                            </button>
                                        </div>
                                        <div className="bg-gray-50 rounded-lg p-3 font-mono text-sm break-all">
                                            {hash.value || <span className="text-gray-400">Hash will appear here...</span>}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>

                    {/* Features Section */}
                    <div className="mt-12 bg-white rounded-3xl shadow-xl p-8 md:p-12">
                        <h2 className="text-3xl font-bold text-gray-900 text-center mb-8">Powerful Hash Generation Features</h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {[
                                { icon: 'fa-bolt', title: 'Multiple Algorithms', desc: 'Generate MD5, SHA-1, SHA-256, SHA-512 simultaneously' },
                                { icon: 'fa-shield-alt', title: 'Secure & Private', desc: 'All hashing happens in your browser - no data sent to servers' },
                                { icon: 'fa-copy', title: 'Easy Copy', desc: 'One-click copy to clipboard for each hash type' },
                                { icon: 'fa-tachometer-alt', title: 'Instant Results', desc: 'Generate hashes in milliseconds without delays' },
                                { icon: 'fa-check-circle', title: 'Accurate', desc: 'Industry-standard hash algorithms with verified results' },
                                { icon: 'fa-mobile-alt', title: 'Mobile Friendly', desc: 'Works perfectly on all devices and screen sizes' }
                            ].map((feature, index) => (
                                <div key={index} className="flex gap-4">
                                    <div className="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-orange-600 to-red-600 rounded-xl flex items-center justify-center text-white">
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
                        <h2 className="text-3xl font-bold text-gray-900 mb-6">What is a Hash Generator?</h2>
                        <p className="text-gray-700 leading-relaxed mb-6">
                            A hash generator creates a fixed-size string (hash) from input data using cryptographic hash functions. 
                            Our free online hash generator supports multiple algorithms including MD5, SHA-1, SHA-256, and SHA-512, 
                            making it perfect for password hashing, file verification, data integrity checks, and security applications.
                        </p>
                        
                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Hash Algorithms Explained</h3>
                        
                        <div className="space-y-4 mb-6">
                            <div className="border-l-4 border-blue-500 pl-4">
                                <h4 className="font-semibold text-gray-900 mb-2">MD5 (Message Digest Algorithm 5)</h4>
                                <p className="text-gray-700 text-sm leading-relaxed">
                                    Produces a 128-bit (32 character) hash. While fast and widely used for checksums, 
                                    MD5 is not recommended for security-critical applications due to known vulnerabilities. 
                                    Best for: file verification, non-cryptographic checksums.
                                </p>
                            </div>
                            
                            <div className="border-l-4 border-green-500 pl-4">
                                <h4 className="font-semibold text-gray-900 mb-2">SHA-1 (Secure Hash Algorithm 1)</h4>
                                <p className="text-gray-700 text-sm leading-relaxed">
                                    Generates a 160-bit (40 character) hash. More secure than MD5 but also deprecated for cryptographic use. 
                                    Best for: legacy system compatibility, Git commits.
                                </p>
                            </div>
                            
                            <div className="border-l-4 border-purple-500 pl-4">
                                <h4 className="font-semibold text-gray-900 mb-2">SHA-256 (Secure Hash Algorithm 256-bit)</h4>
                                <p className="text-gray-700 text-sm leading-relaxed">
                                    Creates a 256-bit (64 character) hash. Part of the SHA-2 family and currently considered secure. 
                                    Best for: password hashing, digital signatures, blockchain, SSL certificates.
                                </p>
                            </div>
                            
                            <div className="border-l-4 border-pink-500 pl-4">
                                <h4 className="font-semibold text-gray-900 mb-2">SHA-512 (Secure Hash Algorithm 512-bit)</h4>
                                <p className="text-gray-700 text-sm leading-relaxed">
                                    Produces a 512-bit (128 character) hash. The most secure option in our tool, offering maximum collision resistance. 
                                    Best for: high-security applications, certificate authorities, sensitive data protection.
                                </p>
                            </div>
                        </div>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Common Use Cases</h3>
                        <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                            <li><strong>Password Storage:</strong> Hash passwords before storing in databases (use SHA-256 or SHA-512 with salt)</li>
                            <li><strong>File Integrity Verification:</strong> Compare file hashes to detect modifications or corruption</li>
                            <li><strong>Digital Signatures:</strong> Create unique identifiers for documents and data</li>
                            <li><strong>Data Deduplication:</strong> Identify duplicate files by comparing their hashes</li>
                            <li><strong>Checksum Validation:</strong> Verify downloaded files match their published checksums</li>
                            <li><strong>API Authentication:</strong> Generate secure tokens for API requests</li>
                            <li><strong>Blockchain Applications:</strong> Create unique identifiers for transactions</li>
                            <li><strong>Cache Keys:</strong> Generate unique keys for caching systems</li>
                        </ul>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">How to Use the Hash Generator</h3>
                        <ol className="list-decimal list-inside text-gray-700 space-y-2 mb-6">
                            <li>Enter your text, password, or data in the input field</li>
                            <li>Click "Generate All Hashes" to create MD5, SHA-1, SHA-256, and SHA-512 hashes</li>
                            <li>Click the "Copy" button next to any hash to copy it to your clipboard</li>
                            <li>Use the generated hashes in your applications or for verification purposes</li>
                        </ol>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Hash Security Best Practices</h3>
                        <ul className="list-disc list-inside text-gray-700 space-y-2 mb-6">
                            <li><strong>Always Use Salt:</strong> Add random data (salt) before hashing passwords to prevent rainbow table attacks</li>
                            <li><strong>Choose Strong Algorithms:</strong> Use SHA-256 or SHA-512 for security-critical applications</li>
                            <li><strong>Avoid MD5 for Security:</strong> MD5 is compromised and should only be used for non-security checksums</li>
                            <li><strong>Use Proper Key Derivation:</strong> For passwords, use bcrypt, scrypt, or Argon2 instead of plain SHA</li>
                            <li><strong>Never Decrypt Hashes:</strong> Hashes are one-way functions - they cannot be reversed</li>
                            <li><strong>Compare Hashes Safely:</strong> Use constant-time comparison to prevent timing attacks</li>
                        </ul>

                        <h3 className="text-2xl font-bold text-gray-900 mb-4 mt-8">Frequently Asked Questions</h3>
                        
                        <div className="space-y-4">
                            <div className="border-b border-gray-200 pb-4">
                                <h4 className="font-semibold text-gray-900 mb-2">Can I reverse a hash to get the original text?</h4>
                                <p className="text-gray-700 text-sm">No. Hash functions are one-way cryptographic operations. Once data is hashed, it cannot be "unhashed" or decrypted back to the original. This is by design for security purposes.</p>
                            </div>
                            
                            <div className="border-b border-gray-200 pb-4">
                                <h4 className="font-semibold text-gray-900 mb-2">Which hash algorithm should I use?</h4>
                                <p className="text-gray-700 text-sm">For security applications, use SHA-256 or SHA-512. For file checksums where security isn't critical, MD5 or SHA-1 are acceptable. For password hashing in production, use bcrypt, scrypt, or Argon2.</p>
                            </div>
                            
                            <div className="border-b border-gray-200 pb-4">
                                <h4 className="font-semibold text-gray-900 mb-2">Is it safe to use this online hash generator?</h4>
                                <p className="text-gray-700 text-sm">Yes! All hashing happens entirely in your browser using JavaScript. Your input data never leaves your device or gets sent to any server. However, never hash truly sensitive data (like real passwords) in any online tool.</p>
                            </div>
                            
                            <div className="border-b border-gray-200 pb-4">
                                <h4 className="font-semibold text-gray-900 mb-2">Why are the hash lengths different?</h4>
                                <p className="text-gray-700 text-sm">Each algorithm produces a fixed-length output regardless of input size: MD5 (32 chars), SHA-1 (40 chars), SHA-256 (64 chars), SHA-512 (128 chars). Longer hashes generally provide better collision resistance.</p>
                            </div>
                            
                            <div>
                                <h4 className="font-semibold text-gray-900 mb-2">What is a hash collision?</h4>
                                <p className="text-gray-700 text-sm">A collision occurs when two different inputs produce the same hash output. Modern algorithms like SHA-256 and SHA-512 make collisions extremely unlikely, but MD5 and SHA-1 have known collision vulnerabilities.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default HashGenerator;
