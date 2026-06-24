<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$employees = [
    ["name"=>"Ivan Franco Cada","position"=>"HR Staff","dept"=>"HR","img"=>"images/ivan.jpeg"],
    ["name"=>"Jane Anne Apolin","position"=>"HR Staff","dept"=>"HR","img"=>"images/jane.jpeg"],
    ["name"=>"Angel Nyle Santillan","position"=>"Designer","dept"=>"Creative","img"=>"images/angel.png"],
    ["name"=>"Methusela Pearl Abdullatip","position"=>"Programmer","dept"=>"IT","img"=>"images/methusela.png"],
    ["name"=>"Jerome Zabanal","position"=>"HR Staff","dept"=>"HR","img"=>"images/jerome.png"],
    ["name"=>"June Lorinser Mojica","position"=>"Developer","dept"=>"IT","img"=>"images/june.jpg"],
    ["name"=>"Jean Carla Bella","position"=>"Support","dept"=>"IT","img"=>"images/bella.jpg"],
    ["name"=>"Alyssa Kae Segura","position"=>"HR Staff","dept"=>"HR","img"=>"images/alyssa.jpg"],
    ["name"=>"Ranaijah Jozainne Galimba","position"=>"Analyst","dept"=>"Finance","img"=>"images/ranajiah.png"],
    ["name"=>"Richelle Laxamana","position"=>"UI Designer","dept"=>"Design","img"=>"images/richelle.png"],
];

$total = count($employees);
$hr = $it = $creative = $finance = $design = 0;

foreach($employees as $e){
    if($e['dept']=="HR") $hr++;
    if($e['dept']=="IT") $it++;
    if($e['dept']=="Creative") $creative++;
    if($e['dept']=="Finance") $finance++;
    if($e['dept']=="Design") $design++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cyberpunk HR Dashboard</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">

<style>
:root{
    --bg:#05060a;
    --panel:#0b0f1a;
    --text:#e5e7eb;
    --neon:#00f5ff;
    --neon2:#ff00ff;
}

*{
    box-sizing: border-box;
}

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: radial-gradient(circle at top, #0a0f1f, var(--bg));
    color:var(--text);
    overflow-x: hidden;
}

/* SCAN LINE EFFECT */
body::before{
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: repeating-linear-gradient(
        0deg,
        rgba(0,245,255,0.03),
        rgba(0,245,255,0.03) 1px,
        transparent 1px,
        transparent 2px
    );
    pointer-events: none;
    z-index: 9999;
}

/* TOP NAV */
.topnav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 20px;
    border-bottom:2px solid rgba(0,245,255,0.3);
    background:rgba(10,15,30,0.85);
    backdrop-filter: blur(10px);
    position:sticky;
    top:0;
    z-index: 100;
    box-shadow: 0 0 20px rgba(0,245,255,0.15);
}

.brand{
    font-weight:900;
    color:var(--neon);
    text-shadow:0 0 10px var(--neon), 0 0 20px var(--neon);
    font-size: 1.4rem;
    letter-spacing: 2px;
    font-family: 'Orbitron', sans-serif;
    text-transform: uppercase;
}

.nav-right{
    display: flex;
    align-items: center;
    gap: 15px;
}

.welcome-text{
    color: var(--neon);
    font-weight: bold;
    text-shadow: 0 0 8px var(--neon);
}

/* LOGOUT BUTTON */
.logout-btn{
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    color:white;
    font-weight:bold;
    background:linear-gradient(45deg,#ff004c,#ff4df0);
    border:2px solid rgba(255,0,100,0.6);
    box-shadow:0 0 15px rgba(255,0,100,0.7);
    transition:0.3s;
    font-size: 0.95rem;
    cursor: pointer;
}

.logout-btn:hover{
    transform:scale(1.08);
    box-shadow:0 0 30px rgba(255,0,100,1);
    border-color: rgba(255,0,100,1);
    color: white;
}

.logout-btn:active{
    transform:scale(0.98);
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin:30px 0;
}

.stat-card{
    background: linear-gradient(135deg, rgba(0,245,255,0.08), rgba(255,0,255,0.08));
    border: 2px solid;
    border-image: linear-gradient(135deg, var(--neon), var(--neon2)) 1;
    border-radius:15px;
    padding:25px;
    text-align:center;
    transition:all 0.3s;
    box-shadow: inset 0 0 15px rgba(0,245,255,0.1), 0 0 20px rgba(0,245,255,0.2);
    position: relative;
    overflow: hidden;
}

.stat-card::before{
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(0,245,255,0.1), transparent);
    animation: glow 4s infinite;
}

@keyframes glow{
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(15px, 15px); }
}

.stat-card:hover{
    transform:translateY(-8px);
    box-shadow: inset 0 0 20px rgba(0,245,255,0.2), 0 0 30px var(--neon);
    border-image: linear-gradient(135deg, var(--neon2), var(--neon)) 1;
}

.stat-card h3{
    font-size: 2.5rem;
    margin: 10px 0;
    color: var(--neon);
    text-shadow: 0 0 10px var(--neon);
    font-family: 'Orbitron', sans-serif;
    font-weight: 900;
}

.stat-card p{
    color: var(--text);
    font-size: 1rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* EMPLOYEE */
.emp-card{
    background: linear-gradient(135deg, rgba(0,245,255,0.08), rgba(255,0,255,0.08));
    border-radius:15px;
    padding:15px;
    cursor:pointer;
    transition:all 0.3s;
    border: 2px solid rgba(0,245,255,0.2);
    box-shadow: 0 0 15px rgba(0,245,255,0.1);
    position: relative;
    overflow: hidden;
}

.emp-card::before{
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,0,255,0.15), transparent);
    opacity: 0;
    transition: opacity 0.3s;
}

.emp-card:hover{
    transform:translateY(-8px) scale(1.03);
    box-shadow:0 0 25px var(--neon), inset 0 0 15px rgba(0,245,255,0.1);
    border-color: var(--neon);
}

.emp-card:hover::before{
    opacity: 1;
}

.emp-img{
    width:100%;
    aspect-ratio:1/1;
    object-fit:cover;
    border-radius:12px;
    border:3px solid var(--neon);
    box-shadow:0 0 15px var(--neon), inset 0 0 10px var(--neon);
    transition: 0.3s;
}

.emp-card:hover .emp-img{
    box-shadow:0 0 25px var(--neon), inset 0 0 15px var(--neon);
}

.emp-card h6{
    margin-top: 12px;
    font-weight: bold;
    color: var(--text);
    font-size: 1rem;
}

.emp-card small{
    color: rgba(229, 231, 235, 0.8);
    font-size: 0.85rem;
}

.emp-dept{
    color:var(--neon);
    font-size:12px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* MODAL */
.modal-bg{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.92);
    justify-content:center;
    align-items:center;
    z-index: 1000;
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn{
    from { background: rgba(0,0,0,0); }
    to { background: rgba(0,0,0,0.92); }
}

.modal-box{
    width:90%;
    max-width:600px;
    background: linear-gradient(135deg, rgba(11,15,26,0.95), rgba(20,25,40,0.95));
    padding:35px;
    border-radius:20px;
    text-align:center;
    border: 2px solid var(--neon);
    box-shadow:0 0 40px var(--neon), inset 0 0 20px rgba(0,245,255,0.1);
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp{
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-img{
    width:180px;
    height:180px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid var(--neon2);
    box-shadow:0 0 25px var(--neon2), inset 0 0 15px var(--neon2);
}

.modal-box h4{
    color: var(--neon);
    text-shadow: 0 0 10px var(--neon);
    margin-top: 20px;
    font-family: 'Orbitron', sans-serif;
    font-weight: bold;
    text-transform: uppercase;
}

.modal-box p{
    color: var(--text);
    margin: 10px 0;
}

.modal-box .btn{
    margin-top: 15px;
}

.btn-close-modal{
    background: linear-gradient(45deg, #00f5ff, #00d4ff);
    border: 2px solid var(--neon);
    color: black;
    font-weight: bold;
    padding: 10px 25px;
    border-radius: 10px;
    box-shadow: 0 0 15px var(--neon);
    transition: 0.3s;
    cursor: pointer;
}

.btn-close-modal:hover{
    transform: scale(1.05);
    box-shadow: 0 0 25px var(--neon);
}

/* LOGOUT MODAL */
.logout-modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.92);
    justify-content:center;
    align-items:center;
    z-index: 1001;
    animation: fadeIn 0.3s ease-in;
}

.logout-box{
    background: linear-gradient(135deg, rgba(11,15,26,0.95), rgba(40,10,20,0.95));
    border:2px solid #ff004c;
    box-shadow:0 0 40px #ff004c, inset 0 0 20px rgba(255,0,76,0.1);
    padding:35px;
    border-radius:15px;
    text-align:center;
    width:90%;
    max-width:400px;
    color:white;
    animation: slideUp 0.3s ease-out;
}

.logout-box h3{
    color: #ff004c;
    text-shadow: 0 0 10px #ff004c;
    font-family: 'Orbitron', sans-serif;
    font-weight: bold;
    font-size: 1.5rem;
    margin-bottom: 15px;
}

.logout-box p{
    color: var(--text);
    margin: 15px 0;
}

.logout-btn-group{
    display:flex;
    gap:12px;
    justify-content:center;
    margin-top: 20px;
}

.btn-yes{
    background: linear-gradient(45deg, #ff004c, #ff4df0);
    border: 2px solid #ff004c;
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: bold;
    box-shadow: 0 0 15px #ff004c;
    transition: 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-yes:hover{
    transform: scale(1.05);
    box-shadow: 0 0 25px #ff004c;
}

.btn-cancel{
    background: rgba(100, 100, 120, 0.5);
    border: 2px solid rgba(100, 100, 120, 0.8);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: bold;
    box-shadow: 0 0 10px rgba(100, 100, 120, 0.5);
    transition: 0.3s;
    cursor: pointer;
}

.btn-cancel:hover{
    background: rgba(100, 100, 120, 0.7);
    box-shadow: 0 0 15px rgba(100, 100, 120, 0.7);
}

/* CONTAINER */
.container{
    padding: 20px;
}

/* RESPONSIVE */
@media (max-width: 768px){
    .brand{
        font-size: 1.1rem;
    }

    .nav-right{
        flex-direction: column;
        gap: 8px;
    }

    .logout-btn{
        padding: 8px 12px;
        font-size: 0.85rem;
    }

    .stat-card h3{
        font-size: 2rem;
    }

    .modal-box{
        padding: 25px;
    }

    .logout-box{
        padding: 25px;
    }
}
</style>
</head>

<body>

<!-- TOP NAV -->
<div class="topnav">
    <div class="brand">⚡ CYBER HR SYSTEM</div>

    <div class="nav-right">
        <span class="welcome-text">Welcome, <?php echo $_SESSION['username']; ?></span>
        <a href="#" class="logout-btn" onclick="confirmLogout(event)">
            ⚠ LOGOUT
        </a>
    </div>
</div>

<div class="container">

<!-- STATS -->
<div class="stats">

    <div class="stat-card">
        <h3><?php echo $total; ?></h3>
        <p>Total Employees</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $hr; ?></h3>
        <p>HR Dept</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $it; ?></h3>
        <p>IT Dept</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $creative; ?></h3>
        <p>Creative Dept</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $finance; ?></h3>
        <p>Finance Dept</p>
    </div>

    <div class="stat-card">
        <h3><?php echo $design; ?></h3>
        <p>Design Dept</p>
    </div>

</div>

<!-- EMPLOYEES -->
<div class="row g-4">

<?php foreach($employees as $emp): ?>
<div class="col-md-4 col-lg-3">

<div class="emp-card"
onclick="openModal('<?php echo $emp['name']; ?>','<?php echo $emp['position']; ?>','<?php echo $emp['dept']; ?>','<?php echo $emp['img']; ?>')">

    <img class="emp-img" src="<?php echo $emp['img']; ?>" alt="<?php echo $emp['name']; ?>">
    <h6><?php echo $emp['name']; ?></h6>
    <small><?php echo $emp['position']; ?></small><br>
    <span class="emp-dept"><?php echo $emp['dept']; ?></span>

</div>

</div>
<?php endforeach; ?>

</div>
</div>

<!-- EMPLOYEE MODAL -->
<div class="modal-bg" id="modal" onclick="closeModal()">
    <div class="modal-box" onclick="event.stopPropagation()">
        <img id="mimg" class="modal-img" alt="Employee"><br><br>
        <h4 id="mname"></h4>
        <p id="mpos"></p>
        <p id="mdept"></p>

        <button onclick="closeModal()" class="btn-close-modal">CLOSE</button>
    </div>
</div>

<!-- LOGOUT MODAL -->
<div class="logout-modal" id="logoutModal" onclick="closeLogout()">
    <div class="logout-box" onclick="event.stopPropagation()">
        <h3>⚠ SYSTEM ALERT</h3>
        <p>Are you sure you want to logout?</p>

        <div class="logout-btn-group">
            <a href="logout.php" class="btn-yes">YES EXIT</a>
            <button onclick="closeLogout()" class="btn-cancel">CANCEL</button>
        </div>
    </div>
</div>

<script>

function openModal(name,pos,dept,img){
    document.getElementById("modal").style.display="flex";
    document.getElementById("mname").innerText=name;
    document.getElementById("mpos").innerText="Position: "+pos;
    document.getElementById("mdept").innerText="Department: "+dept;
    document.getElementById("mimg").src=img;
}

function closeModal(){
    document.getElementById("modal").style.display="none";
}

/* LOGOUT */
function confirmLogout(e){
    e.preventDefault();
    document.getElementById("logoutModal").style.display="flex";
}

function closeLogout(){
    document.getElementById("logoutModal").style.display="none";
}

</script>

</body>
</html>