<?php
// index.php
include 'includes/header.php';
// The header opens the <body> and <main class="container"> tags
?>

    <section class="hero-section">
        <h2>Welcome: Your Personal Productivity Hub</h2>
        <p class="tagline">Organize tasks, meet deadlines, and reclaim your time with a simple, powerful to-do list system.</p>
        <a href="signup.php" class="cta-button">Get Started Now</a>
    </section>

    <hr>

    <section class="info-section">
        <h3>
             <i class="fa fa-tasks" aria-hidden="true"></i>
             What is ToDo Atleast
        </h3>
        <p>TaskFlow is a simple yet effective task management and scheduling system built with PHP and MySQL. It's designed to be your central digital notebook, keeping track of everything you need to do, from daily chores to long-term goals.</p>
    </section>
    
    <hr>

    <h3>
        <i class="fa fa-bullseye" aria-hidden="true"></i>
         How TaskFlow Helps You Manage Time
    </h3>

    <div class="features-grid">
        <div class="feature-box">
            <h4>
                <i class="fa fa-eye" aria-hidden="true"></i>
                Clear Visualization
            </h4>
            <p>Our Calendar View on the home page gives you an instant overview of deadlines. See exactly which days are busy and which tasks are upcoming, helping you plan your week without overload.</p>
        </div>
        
        <div class="feature-box">
            <h4>
                <i class="fa fa-line-chart" aria-hidden="true"></i>
                Prioritization & Focus
            </h4>
            <p>By capturing all tasks in one place, you free your mind from constant worrying and remembering. Focus on the task at hand, knowing the system will remind you what's next.</p>
        </div>
        
        <div class="feature-box">
            <h4>
                <i class="fa fa-calendar" aria-hidden="true"></i>
                 Accountability & Progress
            </h4>
            <p>Marking tasks as complete provides a satisfying visual cue of your progress. This positive feedback loop motivates you to maintain momentum and achieve more consistent productivity.</p>
        </div>
    </div>
    
    <hr>

    
<?php
// The footer closes the </main> and </body> tags
include 'includes/footer.php';
?>