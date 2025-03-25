<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concern Ticketing System</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .form-container, .ticket-container {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 5px 0;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .ticket-status {
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
            text-transform: capitalize;
        }

        .status-pending {
            background-color: yellow;
        }

        .status-ongoing {
            background-color: orange;
        }

        .status-finished {
            background-color: green;
        }

        .ticket-actions button {
            margin-right: 5px;
        }

        .ticket-actions .delete-btn {
            background-color: red;
            color: white;
        }

        .ticket-actions .delete-btn:hover {
            background-color: darkred;
        }

        .back-button {
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .back-button:hover {
            background-color: #218838;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 95%;
            }
        }

    </style>
</head>
<body>

<header>
    <h1>Concern Ticketing System</h1>
    <nav>
        <a href="#" onclick="showTicketForm()">File a Concern</a>
        <a href="#" onclick="viewTickets()">View Tickets</a>
    </nav>
</header>

<div class="container">
    <!-- Ticket Form Section -->
    <div id="ticketForm" class="form-container" style="display:none;">
        <h2>File a Concern</h2>
        <form id="ticketFormSubmit">
            <label for="description">Concern Description:</label>
            <textarea id="description" name="description" required></textarea><br>

            <label for="unit">Assigned Unit:</label>
            <select id="unit" name="unit" required>
                <option value="Technical Support">Technical Support</option>
                <option value="Customer Service">Customer Service</option>
                <option value="Logistics">Logistics</option>
            </select><br>

            <button type="submit">Submit Concern</button>
        </form>
        <button class="back-button" onclick="backToHome()">Back to Home</button>
    </div>

    <!-- Ticket List Section -->
    <div id="ticketList" class="ticket-container" style="display:none;">
        <h2>All Concerns</h2>
        <table id="ticketTable">
            <thead>
                <tr>
                    <th>Assigned Unit</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Concern Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ticketUl"></tbody>
        </table>
        <button class="back-button" onclick="backToHome()">Back to Home</button>
    </div>
</div>

<script>
    // Function to show the concern filing form
    function showTicketForm() {
        document.getElementById('ticketForm').style.display = 'block';
        document.getElementById('ticketList').style.display = 'none';
    }

    // Function to view all tickets
    function viewTickets() {
        document.getElementById('ticketForm').style.display = 'none';
        document.getElementById('ticketList').style.display = 'block';

        const tickets = JSON.parse(localStorage.getItem('tickets')) || [];
        const ticketUl = document.getElementById('ticketUl');
        ticketUl.innerHTML = '';

        tickets.forEach((ticket, index) => {
            const ticketRow = document.createElement('tr');

            const ticketUnit = document.createElement('td');
            ticketUnit.textContent = ticket.unit;
            ticketRow.appendChild(ticketUnit);

            const ticketStatus = document.createElement('td');
            ticketStatus.classList.add('ticket-status', `status-${ticket.status.toLowerCase()}`);
            ticketStatus.textContent = ticket.status;
            ticketRow.appendChild(ticketStatus);

            const ticketDate = document.createElement('td');
            ticketDate.textContent = ticket.date;
            ticketRow.appendChild(ticketDate);

            const ticketDescription = document.createElement('td');
            ticketDescription.textContent = ticket.description;
            ticketRow.appendChild(ticketDescription);

            const ticketActions = document.createElement('td');
            ticketActions.innerHTML = `
                <button onclick="updateStatus(${index}, 'Pending')" class="status-btn status-pending">Mark as Pending</button>
                <button onclick="updateStatus(${index}, 'Ongoing')" class="status-btn status-ongoing">Mark as Ongoing</button>
                <button onclick="updateStatus(${index}, 'Finished')" class="status-btn status-finished">Mark as Finished</button>
                <button onclick="deleteTicket(${index})" class="delete-btn">Delete</button>
            `;
            ticketRow.appendChild(ticketActions);

            ticketUl.appendChild(ticketRow);
        });
    }

    // Function to handle the ticket form submission
    document.getElementById('ticketFormSubmit').addEventListener('submit', function(e) {
        e.preventDefault();

        const description = document.getElementById('description').value;
        const unit = document.getElementById('unit').value;
        const status = 'Pending'; // Initially, the status is set to Pending
        const date = new Date().toLocaleString(); // Get the current date and time

        const ticket = { description, unit, status, date };
        const tickets = JSON.parse(localStorage.getItem('tickets')) || [];
        tickets.push(ticket);

        localStorage.setItem('tickets', JSON.stringify(tickets));

        alert('Concern filed successfully!');
        backToHome();
    });

    // Function to update the ticket status
    function updateStatus(index, status) {
        const tickets = JSON.parse(localStorage.getItem('tickets')) || [];
        const ticket = tickets[index];

        // Prevent status change if already marked as "Finished"
        if (ticket.status === 'Finished') {
            alert('Ticket is already finished!');
            return;
        }

        ticket.status = status;
        localStorage.setItem('tickets', JSON.stringify(tickets));

        viewTickets(); // Refresh the ticket list to show updated status
    }

    // Function to delete the ticket
    function deleteTicket(index) {
        const tickets = JSON.parse(localStorage.getItem('tickets')) || [];
        tickets.splice(index, 1); // Remove the ticket at the given index

        localStorage.setItem('tickets', JSON.stringify(tickets));

        alert('Ticket deleted successfully!');
        viewTickets(); // Refresh the ticket list
    }

    // Function to go back to the home page
    function backToHome() {
        document.getElementById('ticketForm').style.display = 'none';
        document.getElementById('ticketList').style.display = 'none';
        window.location.href = "#";
    }
</script>

</body>
</html>
