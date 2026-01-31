@extends('website.layouts.app')

@section('title', 'Free Base64 Encoder & Decoder Online Tool')

@section('meta_title', 'Base64 Encoder Decoder - Free Online Tool for Developers')

@section('meta_description', 'Free online Base64 encoder and decoder tool. Encode text to Base64 or decode Base64 to text instantly. Perfect for developers, API testing, and data encoding. No signup required.')

@section('meta_keywords', 'base64 encoder, base64 decoder, encode base64, decode base64, base64 converter, online base64 tool, base64 encode online, base64 decode online, developer tools, text encoder')

@section('schema_markup')
{
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "Base64 Encoder & Decoder",
    "applicationCategory": "DeveloperApplication",
    "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
    },
    "description": "Free online Base64 encoder and decoder tool for developers",
    "browserRequirements": "Requires JavaScript. Requires HTML5.",
    "operatingSystem": "All",
    "url": "{{ url()->current() }}",
    "author": {
        "@type": "Organization",
        "name": "InvidiaTech"
    }
}
@endsection

@section('content')
<style>
    .tool-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        padding: 80px 0 60px;
    }
    
    .tool-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        overflow: hidden;
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tool-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }
    
    .tool-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .tool-header p {
        font-size: 1.1rem;
        opacity: 0.95;
        margin: 0;
    }
    
    .tool-body {
        padding: 40px;
    }
    
    .mode-selector {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        justify-content: center;
    }
    
    .mode-btn {
        flex: 1;
        max-width: 200px;
        padding: 15px 30px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .mode-btn:hover {
        border-color: #f093fb;
        transform: translateY(-2px);
    }
    
    .mode-btn.active {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-color: transparent;
    }
    
    .textarea-container {
        position: relative;
        margin-bottom: 20px;
    }
    
    .textarea-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .char-count {
        font-size: 0.9rem;
        color: #666;
        font-weight: normal;
    }
    
    .base64-textarea {
        width: 100%;
        min-height: 250px;
        padding: 20px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        resize: vertical;
        transition: all 0.3s ease;
    }
    
    .base64-textarea:focus {
        outline: none;
        border-color: #f093fb;
        box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.1);
    }
    
    .base64-textarea.error {
        border-color: #ef4444;
    }
    
    .base64-textarea.success {
        border-color: #10b981;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin: 30px 0;
    }
    
    .btn-tool {
        flex: 1;
        min-width: 140px;
        padding: 14px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(240, 147, 251, 0.4);
    }
    
    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-secondary:hover {
        background: #e5e7eb;
        transform: translateY(-2px);
    }
    
    .status-message {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: none;
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .status-message.show {
        display: block;
    }
    
    .status-message.success {
        background: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }
    
    .status-message.error {
        background: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }
    
    .features-section {
        background: #f9fafb;
        padding: 40px;
        margin-top: 40px;
        border-radius: 12px;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-top: 25px;
    }
    
    .feature-item {
        display: flex;
        align-items: start;
        gap: 15px;
    }
    
    .feature-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .feature-content h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 5px;
    }
    
    .feature-content p {
        font-size: 0.95rem;
        color: #6b7280;
        margin: 0;
    }
    
    .seo-content {
        background: white;
        padding: 40px;
        margin-top: 30px;
        border-radius: 12px;
    }
    
    .seo-content h2 {
        font-size: 1.8rem;
        color: #1f2937;
        margin-bottom: 20px;
    }
    
    .seo-content h3 {
        font-size: 1.4rem;
        color: #374151;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    
    .seo-content p {
        color: #4b5563;
        line-height: 1.8;
        margin-bottom: 15px;
    }
    
    .seo-content ul {
        color: #4b5563;
        line-height: 1.8;
        margin-left: 20px;
    }
    
    .seo-content code {
        background: #f3f4f6;
        padding: 2px 8px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #f5576c;
    }
    
    @media (max-width: 768px) {
        .tool-header h1 {
            font-size: 1.8rem;
        }
        
        .mode-selector {
            flex-direction: column;
        }
        
        .mode-btn {
            max-width: 100%;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-tool {
            width: 100%;
        }
    }
</style>

<div class="tool-container">
    <div class="container">
        <div class="tool-card">
            <div class="tool-header">
                <h1><i class="fas fa-exchange-alt"></i> Base64 Encoder & Decoder</h1>
                <p>Encode and decode Base64 strings instantly</p>
            </div>
            
            <div class="tool-body">
                <div class="mode-selector">
                    <button class="mode-btn active" id="encodeBtn" onclick="setMode('encode')">
                        <i class="fas fa-lock"></i> Encode
                    </button>
                    <button class="mode-btn" id="decodeBtn" onclick="setMode('decode')">
                        <i class="fas fa-unlock"></i> Decode
                    </button>
                </div>
                
                <div id="statusMessage" class="status-message"></div>
                
                <div class="textarea-container">
                    <div class="textarea-label">
                        <span id="inputLabel"><i class="fas fa-file-alt"></i> Input Text</span>
                        <span class="char-count" id="inputCount">0 characters</span>
                    </div>
                    <textarea 
                        id="inputText" 
                        class="base64-textarea" 
                        placeholder="Enter text to encode to Base64..."
                        spellcheck="false"
                    ></textarea>
                </div>
                
                <div class="action-buttons">
                    <button class="btn-tool btn-primary" onclick="processBase64()">
                        <i class="fas fa-play"></i> <span id="actionText">Encode</span>
                    </button>
                    <button class="btn-tool btn-secondary" onclick="copyOutput()">
                        <i class="fas fa-copy"></i> Copy Output
                    </button>
                    <button class="btn-tool btn-secondary" onclick="swapInputOutput()">
                        <i class="fas fa-exchange-alt"></i> Swap
                    </button>
                    <button class="btn-tool btn-secondary" onclick="clearAll()">
                        <i class="fas fa-trash"></i> Clear
                    </button>
                </div>
                
                <div class="textarea-container">
                    <div class="textarea-label">
                        <span id="outputLabel"><i class="fas fa-check-circle"></i> Base64 Output</span>
                        <span class="char-count" id="outputCount">0 characters</span>
                    </div>
                    <textarea 
                        id="outputText" 
                        class="base64-textarea" 
                        placeholder="Encoded result will appear here..."
                        readonly
                        spellcheck="false"
                    ></textarea>
                </div>
            </div>
        </div>
        
        <div class="features-section">
            <h2 style="font-size: 2rem; font-weight: 700; color: #1f2937; text-align: center; margin-bottom: 10px;">
                Key Features
            </h2>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Secure Encoding</h3>
                        <p>Convert text to Base64 format securely in your browser</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-unlock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Fast Decoding</h3>
                        <p>Decode Base64 strings back to original text instantly</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Two-Way Conversion</h3>
                        <p>Switch between encoding and decoding with one click</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>100% Private</h3>
                        <p>All processing happens locally - no data sent to servers</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Instant Results</h3>
                        <p>Process text of any length without delays</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Works Everywhere</h3>
                        <p>Use on desktop, tablet, or mobile devices</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="seo-content">
            <h2>What is Base64 Encoding?</h2>
            <p>
                Base64 is a binary-to-text encoding scheme that represents binary data in an ASCII string format. It's commonly used 
                to encode data that needs to be stored or transferred over media designed to handle text. Our free online Base64 
                encoder and decoder tool helps developers quickly convert between text and Base64 format.
            </p>
            
            <h3>Why Use Base64 Encoding?</h3>
            <p>
                Base64 encoding is essential in modern web development and data transmission for several reasons:
            </p>
            <ul>
                <li><strong>Data URLs:</strong> Embed images and files directly in HTML/CSS using data URIs</li>
                <li><strong>Email Attachments:</strong> MIME encoding for email attachments uses Base64</li>
                <li><strong>API Authentication:</strong> Basic authentication headers use Base64 encoding</li>
                <li><strong>Data Storage:</strong> Store binary data in JSON or XML formats</li>
                <li><strong>URL Safety:</strong> Transmit binary data safely in URLs and query strings</li>
                <li><strong>Database Storage:</strong> Store binary data in text-based database fields</li>
            </ul>
            
            <h3>Common Use Cases for Developers</h3>
            <ul>
                <li>Encoding credentials for HTTP Basic Authentication headers</li>
                <li>Creating data URLs for inline images (<code>data:image/png;base64,...</code>)</li>
                <li>Encoding binary data for JSON APIs</li>
                <li>Storing file uploads in databases</li>
                <li>Debugging encoded data in API responses</li>
                <li>Converting images to Base64 for CSS embedding</li>
                <li>Testing authentication mechanisms</li>
                <li>Email attachment encoding (MIME)</li>
            </ul>
            
            <h3>How to Use the Base64 Tool</h3>
            <p>Our Base64 encoder/decoder is straightforward to use:</p>
            <ol>
                <li>Select "Encode" or "Decode" mode using the buttons at the top</li>
                <li>Paste or type your text in the input field</li>
                <li>Click the "Encode" or "Decode" button to process</li>
                <li>The result appears instantly in the output field</li>
                <li>Use "Copy Output" to copy the result to your clipboard</li>
                <li>Use "Swap" to move output back to input for reverse conversion</li>
            </ol>
            
            <h3>Understanding Base64 Format</h3>
            <p>
                Base64 encoding converts binary data into 64 printable ASCII characters. These characters include:
            </p>
            <ul>
                <li>Uppercase letters A-Z</li>
                <li>Lowercase letters a-z</li>
                <li>Digits 0-9</li>
                <li>Plus sign (+) and forward slash (/)</li>
                <li>Equals sign (=) used for padding</li>
            </ul>
            <p>
                For example, the text "Hello World" encodes to <code>SGVsbG8gV29ybGQ=</code> in Base64 format.
            </p>
            
            <h3>Base64 in Web Development</h3>
            <p>
                Modern web developers use Base64 encoding for various purposes:
            </p>
            <ul>
                <li><strong>Inline Images:</strong> Reduce HTTP requests by embedding small images in CSS/HTML</li>
                <li><strong>Font Embedding:</strong> Include custom fonts directly in stylesheets</li>
                <li><strong>API Tokens:</strong> Encode authentication tokens for transmission</li>
                <li><strong>Local Storage:</strong> Store binary data in browser localStorage</li>
                <li><strong>WebSockets:</strong> Send binary data over text-based protocols</li>
            </ul>
            
            <h3>Important Notes</h3>
            <ul>
                <li>Base64 is encoding, not encryption - it doesn't provide security</li>
                <li>Encoded data is approximately 33% larger than the original</li>
                <li>Always use HTTPS when transmitting sensitive Base64-encoded data</li>
                <li>For security, combine Base64 with encryption algorithms</li>
                <li>Base64 encoding is reversible - anyone can decode it</li>
            </ul>
        </div>
    </div>
</div>

<script>
    let currentMode = 'encode';
    const inputText = document.getElementById('inputText');
    const outputText = document.getElementById('outputText');
    const statusMessage = document.getElementById('statusMessage');
    const inputCount = document.getElementById('inputCount');
    const outputCount = document.getElementById('outputCount');
    const inputLabel = document.getElementById('inputLabel');
    const outputLabel = document.getElementById('outputLabel');
    const actionText = document.getElementById('actionText');
    const encodeBtn = document.getElementById('encodeBtn');
    const decodeBtn = document.getElementById('decodeBtn');
    
    // Update character count
    inputText.addEventListener('input', function() {
        inputCount.textContent = `${this.value.length} characters`;
    });
    
    function showMessage(message, type) {
        statusMessage.textContent = message;
        statusMessage.className = `status-message show ${type}`;
        setTimeout(() => {
            statusMessage.classList.remove('show');
        }, 4000);
    }
    
    function setMode(mode) {
        currentMode = mode;
        
        if (mode === 'encode') {
            encodeBtn.classList.add('active');
            decodeBtn.classList.remove('active');
            inputLabel.innerHTML = '<i class="fas fa-file-alt"></i> Input Text';
            outputLabel.innerHTML = '<i class="fas fa-check-circle"></i> Base64 Output';
            actionText.textContent = 'Encode';
            inputText.placeholder = 'Enter text to encode to Base64...';
            outputText.placeholder = 'Encoded result will appear here...';
        } else {
            decodeBtn.classList.add('active');
            encodeBtn.classList.remove('active');
            inputLabel.innerHTML = '<i class="fas fa-file-code"></i> Base64 Input';
            outputLabel.innerHTML = '<i class="fas fa-check-circle"></i> Decoded Text';
            actionText.textContent = 'Decode';
            inputText.placeholder = 'Enter Base64 string to decode...';
            outputText.placeholder = 'Decoded result will appear here...';
        }
        
        // Clear fields when switching modes
        clearAll();
    }
    
    function processBase64() {
        const input = inputText.value.trim();
        
        if (!input) {
            showMessage('Please enter some text to process', 'error');
            inputText.classList.add('error');
            return;
        }
        
        try {
            if (currentMode === 'encode') {
                const encoded = btoa(unescape(encodeURIComponent(input)));
                outputText.value = encoded;
                outputCount.textContent = `${encoded.length} characters`;
                showMessage('✓ Text encoded to Base64 successfully!', 'success');
            } else {
                const decoded = decodeURIComponent(escape(atob(input)));
                outputText.value = decoded;
                outputCount.textContent = `${decoded.length} characters`;
                showMessage('✓ Base64 decoded successfully!', 'success');
            }
            
            inputText.classList.remove('error');
            inputText.classList.add('success');
            outputText.classList.add('success');
        } catch (error) {
            inputText.classList.add('error');
            inputText.classList.remove('success');
            
            if (currentMode === 'decode') {
                showMessage('✗ Invalid Base64 string. Please check your input.', 'error');
            } else {
                showMessage('✗ Error encoding text: ' + error.message, 'error');
            }
            outputText.value = '';
        }
    }
    
    function copyOutput() {
        const output = outputText.value;
        
        if (!output) {
            showMessage('No output to copy. Please process text first.', 'error');
            return;
        }
        
        navigator.clipboard.writeText(output).then(() => {
            showMessage('✓ Copied to clipboard!', 'success');
        }).catch(err => {
            showMessage('✗ Failed to copy to clipboard', 'error');
        });
    }
    
    function swapInputOutput() {
        const input = inputText.value;
        const output = outputText.value;
        
        if (!output) {
            showMessage('No output to swap', 'error');
            return;
        }
        
        inputText.value = output;
        outputText.value = '';
        inputCount.textContent = `${output.length} characters`;
        outputCount.textContent = '0 characters';
        
        // Switch mode
        setMode(currentMode === 'encode' ? 'decode' : 'encode');
        inputText.value = output;
        inputCount.textContent = `${output.length} characters`;
        
        showMessage('✓ Input and output swapped!', 'success');
    }
    
    function clearAll() {
        inputText.value = '';
        outputText.value = '';
        inputCount.textContent = '0 characters';
        outputCount.textContent = '0 characters';
        inputText.classList.remove('error', 'success');
        outputText.classList.remove('success');
    }
    
    // Add keyboard shortcuts
    inputText.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + Enter to process
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            processBase64();
        }
    });
</script>
@endsection
