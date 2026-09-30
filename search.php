<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$search = $_GET['medicine'] ?? '';

$medicines = [];

if ($search != '') {

    $searchSafe = mysqli_real_escape_string($conn, $search);

    $sql = "SELECT * FROM medicines
            WHERE medicine_name LIKE '%$searchSafe%'";

} else {

    $sql = "SELECT * FROM medicines
            ORDER BY medicine_name ASC";
}

$result = mysqli_query($conn, $sql);

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $medicines[] = $row;

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Search Medicine - PharmaHub</title>

    <link rel="stylesheet" href="search.css">

</head>

<body>

<!-- HEADER -->

<header class="search-header">

    <div class="brand">

        <div class="logo">✚</div>

        <div>
            <h2>PharmaHub</h2>
            <span>Smart Pharmacy</span>
        </div>

    </div>

    <div class="date-time">

        📅 <span id="currentDate"></span>

        <span class="divider"></span>

        🕐 <span id="currentTime"></span>

    </div>

</header>


<!-- MAIN -->

<main class="main-container">


    <!-- SEARCH BOX -->

    <section class="search-card">

        <div class="search-content">

            <h1>Search Medicine</h1>

            <p>
                Find and manage medicines in your inventory
            </p>


            <form method="GET" action="search.php">

                <div class="search-area">

                    <div class="search-input">

                        <span>⌕</span>

                        <input
                            type="text"
                            name="medicine"
                            placeholder="Search medicine name..."
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                    </div>

                    <button type="submit">

                        🔍 Search

                    </button>

                </div>

            </form>

        </div>


        <div class="medicine-image">

            <div class="bottle">💊</div>

            <div class="pills">● ● ●</div>

        </div>

    </section>


    <!-- RESULTS -->

    <section class="results-card">

        <div class="results-heading">

            <div>

                <h2>▣ &nbsp; Search Results</h2>

                <?php if ($search != ''): ?>

                    <p>
                        Showing results for
                        <strong>
                            "<?php echo htmlspecialchars($search); ?>"
                        </strong>
                    </p>

                <?php else: ?>

                    <p>
                        Showing all available medicines
                    </p>

                <?php endif; ?>

            </div>


            <div class="result-count">

                <?php echo count($medicines); ?>

                Medicine<?php echo count($medicines) != 1 ? 's' : ''; ?>

                Found

            </div>

        </div>


        <?php if (count($medicines) > 0): ?>

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Medicine Name</th>

                            <th>Price (₹)</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    $i = 1;

                    foreach ($medicines as $row):

                    ?>

                        <tr>

                            <td>
                                <?php echo $i++; ?>
                            </td>


                            <td>

                                <strong class="medicine-name">

                                    <?php
                                    echo htmlspecialchars(
                                        $row['medicine_name']
                                    );
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <strong class="price">

                                    ₹<?php
                                    echo number_format(
                                        (float)$row['price'],
                                        2
                                    );
                                    ?>

                                </strong>

                            </td>


                            <td>

                                <a
                                    class="view-btn"
                                    href="billing.php?medicine=<?php
                                    echo urlencode($row['medicine_name']);
                                    ?>&price=<?php
                                    echo urlencode($row['price']);
                                    ?>"
                                >

                                    🛒 Add to Bill

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="no-results">

                <div class="empty-icon">🔎</div>

                <h3>No Medicine Found</h3>

                <p>
                    Try searching with another medicine name.
                </p>

            </div>

        <?php endif; ?>

    </section>


</main>


<!-- FOOTER -->

<footer>

    © 2026 PharmaHub. All rights reserved.

</footer>


<script>

function updateDateTime() {

    const now = new Date();

    document.getElementById("currentDate").textContent =
        now.toLocaleDateString("en-IN", {
            day: "2-digit",
            month: "short",
            year: "numeric"
        });

    document.getElementById("currentTime").textContent =
        now.toLocaleTimeString("en-IN", {
            hour: "2-digit",
            minute: "2-digit"
        });
}

updateDateTime();

setInterval(updateDateTime, 1000);

</script>

</body>

</html>