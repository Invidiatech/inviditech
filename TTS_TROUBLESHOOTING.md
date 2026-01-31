# 🔧 Text-to-Speech Troubleshooting Guide

## ✅ What I Just Fixed:

### 1. **Better Text Extraction**
- Now cleans HTML content properly
- Removes code blocks (they don't read well)
- Cleans extra whitespace
- Validates text before playing

### 2. **Enhanced Error Handling**
- Added console.log for debugging
- Shows error messages in notifications
- Validates that text exists before playing

### 3. **Improved Voice Loading**
- Tries loading voices multiple times (immediately, 100ms, 500ms)
- Prioritizes US English voices
- Better fallback logic
- Shows voice count in settings panel

### 4. **Added Test Button**
- "🎤 Test Audio" button in settings panel
- Plays "Hello, this is a test" immediately
- Uses your selected voice and speed
- Quick way to verify audio works

### 5. **Debug Information**
- Shows how many voices loaded
- Shows current voice name
- Console logs for all audio events

---

## 🧪 How to Debug:

### **Step 1: Open Browser Console**
Press `F12` or right-click → Inspect → Console tab

### **Step 2: Check Voice Loading**
Look for these console messages:
```
Available voices: 30
Voices: ["Google US English (en-US)", "Google UK English Female (en-GB)", ...]
Using default voice: Google US English
```

**If you see 0 voices:**
- Refresh the page
- Try a different browser (Chrome/Edge work best)
- Check browser settings → Sound permissions

### **Step 3: Test Audio**
1. Click the **🎛️ Settings** button (bottom-right)
2. Look at "Voices loaded: X" at the bottom
3. Click **🎤 Test Audio** button
4. You should hear "Hello, this is a test"

**If test works but article doesn't:**
- Check console for errors
- The article text might be empty
- Try refreshing the page

**If test doesn't work:**
- Browser doesn't support text-to-speech
- Sound is muted
- Browser permissions issue

### **Step 4: Try Playing Article**
1. Click **🔊 Play** button
2. Check console for messages:
   ```
   Text to speak: Lorem ipsum dolor sit amet...
   Text length: 5234
   Selected voice: Google US English
   Speech rate: 1.0
   Using voice: Google US English
   Speech started
   ```

**Expected Console Messages:**
```javascript
✅ "Text to speak: ..." (shows first 100 chars)
✅ "Text length: XXXX" (should be > 100)
✅ "Selected voice: Google US English"
✅ "Speech command sent"
✅ "Speech started" (when audio actually starts)
```

**Error Messages to Look For:**
```javascript
❌ "No text to read" → Article content not loaded
❌ "Speech error: not-allowed" → Browser permissions
❌ "Speech error: interrupted" → Another audio interrupted
❌ "Speech error: network" → Offline or network issue
```

---

## 🎯 Common Issues & Solutions:

### **Issue 1: "Voices loaded: 0"**

**Solution:**
```javascript
// In browser console, try:
window.speechSynthesis.getVoices()

// If returns empty [], try:
setTimeout(() => {
    console.log(window.speechSynthesis.getVoices());
}, 1000);

// Some browsers need time to load voices
```

**Fixes:**
- Refresh page
- Use Chrome/Edge (best support)
- Update browser to latest version

---

### **Issue 2: Test Audio Works, Article Doesn't**

**Possible Causes:**
- Article HTML not loaded yet
- `articleRef.current` is null
- Text content is empty

**Solution:**
1. Check if article is visible on page
2. Open console and type:
   ```javascript
   document.querySelector('.blog-reading')?.textContent
   ```
3. Should show article text
4. If null → Article not rendered yet

---

### **Issue 3: Nothing Happens When Clicking Play**

**Debug Steps:**
1. Open Console (F12)
2. Click Play button
3. Look for console logs

**If no logs appear:**
- JavaScript error before function runs
- Check Console → Errors tab
- Look for red error messages

**If logs appear but no audio:**
- Check "Speech error:" message
- Check browser sound settings
- Try unmuting tab/browser

---

### **Issue 4: Audio Cuts Off Early**

**Causes:**
- Long text might timeout in some browsers
- Browser tab loses focus

**Solutions:**
- Keep tab active while listening
- Split very long articles into sections
- Try different voice (some are more stable)

---

## 🔍 Manual Testing Commands:

Open browser console and try these:

### **1. Check Voice Support**
```javascript
// Check if browser supports speech synthesis
'speechSynthesis' in window
// Should return: true

// Get available voices
window.speechSynthesis.getVoices()
// Should return: Array of voice objects

// Count voices
window.speechSynthesis.getVoices().length
// Should return: number > 0
```

### **2. Simple Test**
```javascript
// Test with simple text
const test = new SpeechSynthesisUtterance('Hello world');
window.speechSynthesis.speak(test);
// Should hear "Hello world"
```

### **3. Test with Voice**
```javascript
const voices = window.speechSynthesis.getVoices();
const test = new SpeechSynthesisUtterance('Testing voice');
test.voice = voices[0];
window.speechSynthesis.speak(test);
```

### **4. Check Article Text**
```javascript
// Get article element
const article = document.querySelector('.blog-reading');
console.log('Article exists:', !!article);

// Get text content
console.log('Text:', article?.textContent?.substring(0, 100));

// Text length
console.log('Length:', article?.textContent?.length);
```

---

## ✅ Success Checklist:

- [ ] Console shows "Available voices: X" (X > 0)
- [ ] Console shows "Using default voice: ..."
- [ ] Settings panel shows "Voices loaded: X" (X > 0)
- [ ] Test Audio button plays sound
- [ ] Console shows "Speech started" when clicking play
- [ ] Audio actually plays from speakers
- [ ] Can pause/resume audio
- [ ] Can change voice and hear difference
- [ ] Can change speed and hear difference

---

## 🌐 Browser Compatibility:

| Browser | Support | Voices | Notes |
|---------|---------|--------|-------|
| Chrome | ✅ Excellent | 30+ | Best support |
| Edge | ✅ Excellent | 30+ | Best support |
| Safari | ✅ Good | 10+ | Works well |
| Firefox | ✅ Good | 10+ | Works well |
| Opera | ✅ Good | 20+ | Works well |
| Mobile Chrome | ✅ Good | 10+ | Works on Android |
| Mobile Safari | ✅ Good | 5+ | Works on iOS |

---

## 💡 Quick Fixes:

### **If Nothing Works:**
1. Try different browser (Chrome/Edge recommended)
2. Update browser to latest version
3. Check browser sound settings
4. Try incognito/private mode
5. Disable browser extensions
6. Clear browser cache

### **If Test Works But Article Doesn't:**
```javascript
// Add this temporarily to your code to debug:
console.log('Article ref:', articleRef.current);
console.log('Article text:', articleRef.current?.textContent?.substring(0, 200));
```

### **If Voices Don't Load:**
```javascript
// Force reload voices (in console)
window.speechSynthesis.cancel();
setTimeout(() => {
    console.log('Voices:', window.speechSynthesis.getVoices());
}, 2000);
```

---

## 📞 What to Check:

1. **Open Console** (F12)
2. **Click 🎛️ Settings**
3. **Look at bottom**: "Voices loaded: X"
   - If X = 0 → Voice loading issue
   - If X > 0 → Voices OK
4. **Click 🎤 Test Audio**
   - Hear sound? → Audio works!
   - No sound? → Browser/sound issue
5. **Click 🔊 Play**
   - Watch console for messages
   - Should see "Speech started"

---

## 🎉 Expected Behavior:

When everything works correctly:

1. **Load Page:**
   - Console: "Available voices: 30"
   - Console: "Using default voice: Google US English"

2. **Open Settings:**
   - Shows "Voices loaded: 30"
   - Shows "Current voice: Google US English"

3. **Click Test Audio:**
   - Hear: "Hello, this is a test"

4. **Click Play:**
   - Console: "Text to speak: ..." 
   - Console: "Speech started"
   - Hear: Article being read aloud

5. **Click Pause:**
   - Audio pauses
   - Console: "Speech paused"

6. **Click Again (Resume):**
   - Audio resumes
   - Console: "Speech resumed"

7. **Click Stop:**
   - Audio stops completely
   - Console: "Speech ended"

---

## 📧 Still Having Issues?

Check the browser console and share:
1. What you see in Console tab
2. Value of "Voices loaded: X"
3. Does Test Audio work?
4. Any red error messages

This will help diagnose the exact issue!
