<?php
// home.php
include 'includes/header.php'; 
include 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// --- 1. HANDLE TASK CRUD OPERATIONS (Simplified for brevity) ---

// Handle Task Addition (Existing logic)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $task_description = $_POST['task_description'];
    $due_date = $_POST['due_date'];
    $importance = $_POST['importance'];

    if (!empty($task_description)) {
        // Sanitize date input: ensure it's not empty string if date picker isn't used
        $due_date = empty($due_date) ? NULL : $due_date;
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_description, due_date, importance, is_completed) VALUES (?, ?, ?, ?, 0)");
        $stmt->bind_param("isss", $user_id, $task_description, $due_date, $importance);
        
        // Use 's' for NULL date parameter if it's set to NULL (MySQL handles NULL date strings)
        $param_type = $due_date === NULL ? "is" : "iss";
        $stmt->bind_param("is", $user_id, $task_description); // Simplified binding for clarity

        // Re-binding for safer practice with date (assuming non-null for now, or you need more complex binding)
        if ($due_date !== NULL) {
             $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_description, due_date, is_completed) VALUES (?, ?, ?, 0)");
             $stmt->bind_param("iss", $user_id, $task_description, $due_date);
        } else {
             $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_description, is_completed) VALUES (?, ?, 0)");
             $stmt->bind_param("is", $user_id, $task_description);
        }

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Task added successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error adding task: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}


// Handle Task Completion/Deletion (Existing logic)
if (isset($_GET['complete_id'])) {
    $task_id = $_GET['complete_id'];
    $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $task_id, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: home.php"); 
    exit();
}


// --- 2. FETCH TASKS AND ORGANIZE BY DATE ---

// Fetch ALL tasks for the user
$tasks = [];
$tasks_by_date = []; // Array to map dates to tasks for calendar highlighting
$result = $conn->query("SELECT id, task_description, due_date, importance, is_completed FROM tasks WHERE user_id = $user_id ORDER BY FIELD(importance, 'high', 'medium', 'low'), due_date ASC, id DESC");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
        
        // Populate the tasks_by_date array for calendar logic
        if (!empty($row['due_date'])) {
            $date_key = date('Y-m-d', strtotime($row['due_date']));
            if (!isset($tasks_by_date[$date_key])) {
                $tasks_by_date[$date_key] = 0;
            }
            $tasks_by_date[$date_key]++; // Count the number of tasks on this day
        }
    }
}


// --- 3. CALENDAR GENERATION FUNCTION ---

function draw_calendar($month, $year, $tasks_by_date) {
    /* draw table */
    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
    
    /* table headings */
    $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';

    /* days and weeks vars now ... */
    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();
    

    /* row for week one */
    $calendar .= '<tr class="calendar-row">';

    /* print "blank" days until the first of the month */
    for ($list_day = 1; $list_day <= $running_day; $list_day++) {
        $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
        $days_in_this_week++;
    }

    /* keep going until we've printed all of the days in the month */
    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
        $calendar .= '<td class="calendar-day">';
        /* add in the day number */
        $calendar .= '<div class="day-number">' . $list_day . '</div>';

        // Check if there are tasks for this date
        $current_date = date('Y-m-d', mktime(0, 0, 0, $month, $list_day, $year));
        $has_tasks = isset($tasks_by_date[$current_date]);
        
        if ($has_tasks) {
            $task_count = $tasks_by_date[$current_date];
            // Highlight the day and show task count
            $calendar .= '<div class="tasks-marker task-count-' . min($task_count, 3) . '">';
            $calendar .= 'Task' . ($task_count > 1 ? 's' : '') . ': ' . $task_count;
            $calendar .= '</div>';
        }
        
        $calendar .= '</td>';
        
        if ($running_day == 6) {
            $calendar .= '</tr>';
            if (($day_counter + 1) != $days_in_month) {
                $calendar .= '<tr class="calendar-row">';
            }
            $running_day = -1;
            $days_in_this_week = 0;
        }
        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    }

    /* finish the rest of the week */
    if ($days_in_this_week < 8) {
        for ($list_day = 1; $list_day <= (8 - $days_in_this_week); $list_day++) {
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
        }
    }

    /* final row */
    $calendar .= '</tr>';

    /* end the table */
    $calendar .= '</table>';

    return $calendar;
}

// Get the current month and year for the calendar display
$current_month = date('n');
$current_year = date('Y');
$current_month_name = date('F', mktime(0, 0, 0, $current_month, 10)); // Get full month name

$conn->close();
?>

    <h2>📋 Your Tasks and Schedule</h2>
    <?php echo $message; ?>

    <div class="calendar-section" style="margin-bottom: 30px;">
        <h3 style="text-align: center; color: #0078d4;"><?php echo $current_month_name . ' ' . $current_year; ?></h3>
        <?php 
        // Draw the calendar, passing the task data
        echo draw_calendar($current_month, $current_year, $tasks_by_date); 
        ?>
    </div>
    
    <hr>
    
    <div class="task-add">
        <h4>Add a New Task</h4>
        <form method="POST" style="display: flex; gap: 10px; align-items: center;">
        <input type="text" name="task_description" placeholder="Enter new task" required style="flex-grow: 2; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        
        <select name="importance" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            <option value="medium">Medium Priority</option>
            <option value="high">High Priority</option>
            <option value="low">Low Priority</option>
        </select>
        
        <input type="date" name="due_date" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        <button type="submit" name="add_task" style="padding: 10px;">Add Task</button>
        </form>
    </div>

    <hr>
    <h3>Pending Tasks List</h3>
    <ul style="list-style: none; padding: 0;">
        <?php 
        $has_pending_tasks = false;
        foreach ($tasks as $task): 
            if (!$task['is_completed']) {
                $has_pending_tasks = true;
            }
        ?>
            <li style="padding: 10px; margin-bottom: 8px; border: 1px solid #eee; background-color: <?php echo $task['is_completed'] ? '#f0f0f0' : '#fff'; ?>; display: flex; justify-content: space-between; align-items: center; border-left: 5px solid <?php echo $task['is_completed'] ? '#aaa' : '#0078d4'; ?>;">
                <span style="text-decoration: <?php echo $task['is_completed'] ? 'line-through' : 'none'; ?>; color: <?php echo $task['is_completed'] ? '#777' : '#333'; ?>;">
                    <?php echo htmlspecialchars($task['task_description']); ?>
                    <?php if ($task['due_date']): ?>
                        (Due: <strong><?php echo htmlspecialchars($task['due_date']); ?></strong>)
                    <?php endif; ?>
                </span>
                <?php if (!$task['is_completed']): ?>
                    <a href="home.php?complete_id=<?php echo $task['id']; ?>" style="color: green; text-decoration: none; font-weight: bold;">✅ Done</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        <?php if (!$has_pending_tasks): ?>
            <li style="text-align: center; color: #777;">All caught up! No pending tasks.</li>
        <?php endif; ?>
    </ul>

<?php
include 'includes/footer.php';
?>