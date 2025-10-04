# 🤖 AI SESSION STARTER PROMPT

> **Use this prompt in OpenAI Codex CLI or any AI assistant to start a new session with full project context**

---

## 📋 COPY & PASTE THIS PROMPT:

```
I'm working on the OFYS (Outdoor Activity Booking Platform) project. Before we start, please read these two important files to understand the project context and where we left off:

1. **@CLAUDE.md** - Contains the session memory, current status, last stopping point, completed tasks, and next steps
2. **@AGENTS.md** - Contains the complete technical architecture, development guidelines, and best practices

After reading both files, please:
1. Confirm you understand the project structure
2. Tell me where we stopped in the last session
3. Summarize the current status (what's completed, what's in progress, what's pending)
4. Ask me what I'd like to work on next

Remember:
- This is a Laravel 12 project with Blade + jQuery + Tailwind CSS
- Livewire and Alpine.js have been REMOVED - don't use them
- Project follows role-based organization (Admin/Customer/Provider/Guest)
- Currently working on Provider functionality
- There are uncommitted changes in the provider section

Ready to continue from where we left off!
```

---

## 🎯 ALTERNATIVE SHORT PROMPT:

```
Hi! I'm continuing work on OFYS project. Please read @CLAUDE.md and @AGENTS.md first to get full context, then tell me where we stopped and what's next.
```

---

## 💡 FOR OPENAI CODEX CLI:

### Option 1: Start with Context
```bash
# Navigate to project directory first
cd /Users/mrpixel/Documents/ofys/ofys

# Then start your AI session with:
"Read @CLAUDE.md and @AGENTS.md to understand the OFYS project context. Tell me where we stopped and what we're working on."
```

### Option 2: Direct File Reference
```bash
# In OpenAI Codex CLI, use @ to reference files
"@CLAUDE.md @AGENTS.md - Review these files and continue from last session"
```

### Option 3: Detailed Start
```bash
"I'm working on OFYS project. Read @CLAUDE.md for session memory and @AGENTS.md for technical guidelines. We stopped while working on Provider functionality. Confirm you understand the context and show me the current status."
```

---

## 🔧 FOR CURSOR AI / GITHUB COPILOT:

```
Context: OFYS - Outdoor Activity Booking Platform (Laravel 12)

Please read:
- @CLAUDE.md (session memory & progress)
- @AGENTS.md (technical architecture)

Then tell me:
1. Where did we stop?
2. What's the current status?
3. What should we work on next?

Project uses: Blade, jQuery, Tailwind CSS (NO Livewire/Alpine.js)
Current focus: Provider functionality
```

---

## 🎨 FOR CHATGPT:

```
I'm continuing work on the OFYS project (Outdoor Activity Booking Platform built with Laravel 12).

Please read these two files first to get full context:

**File 1: CLAUDE.md**
[Paste CLAUDE.md content or upload file]

**File 2: AGENTS.md**
[Paste AGENTS.md content or upload file]

After reading both files, please:
- Confirm you understand where we stopped
- Summarize current status (completed/in-progress/pending)
- Tell me what uncommitted changes exist
- Ask what I want to work on next

Important reminders:
- NO Livewire or Alpine.js (already removed)
- Use Blade + jQuery + Tailwind CSS
- Follow role-based organization
- Currently on: feature/major-refactor-code-providers branch
```

---

## 📱 FOR CLAUDE (New Conversation):

```
Hi Claude! I'm continuing the OFYS project development. Please read these two context files:

1. @CLAUDE.md - Your memory from last session
2. @AGENTS.md - Technical development guide

After reading, tell me:
- Where we stopped (look for "STOPPED HERE" section)
- What changes are uncommitted
- What's next on the priority list

Then ask me what I'd like to work on. Ready to pick up exactly where we left off!
```

---

## 🚀 QUICK START CHECKLIST

When starting a new AI session:

- [ ] Open terminal in project directory: `/Users/mrpixel/Documents/ofys/ofys`
- [ ] Copy the appropriate prompt from above
- [ ] Paste into your AI assistant (Codex CLI, Cursor, ChatGPT, Claude, etc.)
- [ ] Wait for AI to read both files and confirm context
- [ ] AI will tell you where you stopped
- [ ] AI will ask what to work on next
- [ ] Continue seamlessly! 🎉

---

## 💾 AFTER EACH SESSION:

**Always tell the AI to:**
```
"Before we end, please update @CLAUDE.md with:
1. What we completed this session
2. Where we're stopping now (update STOPPED HERE section)
3. What's next for the following session
4. Any new issues or notes

Keep @AGENTS.md updated if we changed architecture or added new patterns."
```

---

## 📝 NOTES:

- The `@` symbol tells most modern AI tools to reference a specific file
- Always start from the project root directory
- Both CLAUDE.md and AGENTS.md must be read for full context
- Update CLAUDE.md at the end of EVERY session
- Update AGENTS.md only when architecture/patterns change

---

## 🎯 EXPECTED AI RESPONSE:

After using this prompt, the AI should respond with something like:

```
✅ I've read both CLAUDE.md and AGENTS.md.

📍 Last Session Summary:
- Studied PROJECT_STRUCTURE.md
- Cleaned up unnecessary .sh and .md files
- Created CLAUDE.md and AGENTS.md
- 🔴 STOPPED: Awaiting instructions for Provider functionality

📊 Current Status:
- Branch: feature/major-refactor-code-providers
- Uncommitted changes:
  • app/Http/Controllers/Provider/ProviderController.php
  • resources/views/provider/activities/create.blade.php
  • routes/web.php

✅ Completed: Major refactoring (Livewire/Alpine.js removed)
🚧 In Progress: Provider section work
⚠️ Known Issue: Register page 500 error

🎯 What would you like to work on next?
```

---

**Last Updated**: October 4, 2025  
**Created by**: Session consolidation task  
**Purpose**: Ensure zero context loss between AI sessions

---

## 🔗 RELATED FILES:

- **CLAUDE.md** - Session memory (read first)
- **AGENTS.md** - Technical guide (read second)
- **This file (PROMPT1.md)** - How to start new sessions

---

*Save this prompt and use it every time you start a new AI session on this project!*

