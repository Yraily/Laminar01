<?php
include '../config/database.php';

$limit = isset($_GET['limit']) ? min(intval($_GET['limit']), 100) : 20;

try {
    $stmt = $pdo->prepare("SELECT * FROM scores ORDER BY score DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    $scores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $scores = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DefensePlants Leaderboard</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .header {
        text-align: center;
        color: white;
        margin-bottom: 30px;
        padding: 30px 20px;
    }

    .header h1 {
        font-size: 3em;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .leaderboard {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .leaderboard-header {
        display: grid;
        grid-template-columns: 80px 1fr 120px 100px;
        gap: 15px;
        padding: 20px;
        background: rgba(168, 85, 247, 0.1);
        font-weight: 600;
        color: #6b7280;
        border-bottom: 2px solid #e5e7eb;
    }

    .score-item {
        display: grid;
        grid-template-columns: 80px 1fr 120px 100px;
        gap: 15px;
        padding: 15px 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .score-item:hover {
        background-color: #f9fafb;
    }

    .score-item:last-child {
        border-bottom: none;
    }

    .top-1 {
        background: linear-gradient(135deg, #FFFBEB, #FEF3C7);
        border-left: 4px solid #F59E0B;
    }

    .top-2 {
        background: linear-gradient(135deg, #F0F9FF, #E0F2FE);
        border-left: 4px solid #0EA5E9;
    }

    .top-3 {
        background: linear-gradient(135deg, #FDF2F8, #FCE7F3);
        border-left: 4px solid #EC4899;
    }

    .rank {
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .medal {
        font-size: 1.2em;
    }

    .score {
        font-weight: 600;
        color: #10b981;
        text-align: right;
    }

    .stage {
        text-align: center;
        color: #6b7280;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    @media (max-width: 768px) {

        .leaderboard-header,
        .score-item {
            grid-template-columns: 60px 1fr 80px 60px;
            padding: 15px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏆 DefensePlants Leaderboard</h1>
            <p>Top <?php echo count($scores); ?> Players</p>
        </div>

        <div class="leaderboard">
            <div class="leaderboard-header">
                <span>Rank</span>
                <span>Player</span>
                <span>Score</span>
                <span>Stage</span>
            </div>

            <?php if (count($scores) > 0): ?>
            <?php foreach ($scores as $index => $score): ?>
            <?php 
                    $rank = $index + 1;
                    $medal = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : ''));
                    ?>
            <div class="score-item <?php echo $rank <= 3 ? 'top-' . $rank : ''; ?>">
                <div class="rank">
                    <?php if ($medal): ?><span class="medal"><?php echo $medal; ?></span><?php endif; ?>
                    <span>#<?php echo $rank; ?></span>
                </div>
                <div class="player-name"><?php echo htmlspecialchars($score['player_name']); ?></div>
                <div class="score"><?php echo number_format($score['score']); ?></div>
                <div class="stage">Stage <?php echo $score['stage']; ?></div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-state">
                <h3>No scores yet</h3>
                <p>Be the first to play and submit your score!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>