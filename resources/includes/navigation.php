<?php
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['rol'] == "admin") { ?>
        <nav>
            <ul>
                <a href="/">
                    <li>Home</li>
                </a>
                <a href="/panel-control">
                    <li>Panel de control</li>
                </a>
                <a href="?logout=true">
                    <li>Cerrar sesión</li>
                </a>
            </ul>
        </nav>
    <?php } else if ($_SESSION['rol'] == "usuario") { ?>
        <nav>
            <ul>
                <a href="/">
                    <li>Home</li>
                </a>
                <a href="?logout=true">
                    <li>Cerrar sesión</li>
                </a>
            </ul>
        </nav>
    <?php } else { ?>
        <nav>
            <ul>
                <a href="/">
                    <li>Home</li>
                </a>
                <a href="?logout=true">
                    <li>Cerrar sesión</li>
                </a>
            </ul>
        </nav>
<?php
    }
}
?>