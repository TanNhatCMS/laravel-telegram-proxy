<h2>Advanced API Tester</h2>
<form id="advancedTestForm">
    <label for="method">HTTP Method:</label><br>
    <select id="httpMethod" name="method" style="width: 100%;">
        <option>GET</option>
        <option selected>POST</option>
        <option>PUT</option>
        <option>DELETE</option>
    </select><br><br>

    <label for="botToken">Bot Token:</label><br>
    <input type="text" id="advBotToken" name="botToken" style="width: 100%;" required><br><br>

    <label for="apiMethod">Telegram API Method (e.g., <code>sendMessage</code>, <code>getMe</code>):</label><br>
    <input type="text" id="apiMethod" name="apiMethod" style="width: 100%;" required><br><br>

    <label for="jsonBody">Request JSON Body:</label><br>
    <textarea id="jsonBody" name="jsonBody" rows="6" style="width: 100%;">{
    "chat_id": "123456789",
    "text": "Hello from Advanced Test"
}</textarea><br><br>

    <button type="submit">Send Request</button>
</form>

<div id="advResponse" style="margin-top: 20px;" class="code"></div>

<script>
    document.getElementById('advancedTestForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const method = document.getElementById('httpMethod').value;
        const token = document.getElementById('advBotToken').value.trim();
        const apiMethod = document.getElementById('apiMethod').value.trim();
        const body = document.getElementById('jsonBody').value;

        const url = `/bot${token}/${apiMethod}`;

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: ['GET', 'DELETE'].includes(method) ? null : body
            });

            const text = await res.text();
            document.getElementById('advResponse').textContent = `Status: ${res.status}\n\n${text}`;
        } catch (err) {
            document.getElementById('advResponse').textContent = `Error: ${err.message}`;
        }
    });
</script>

<style>
    form input, form textarea {
        padding: 8px;
        font-size: 1rem;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    form button {
        background-color: #0088cc;
        color: white;
        border: none;
        padding: 10px 16px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #0077b3;
    }
</style>
