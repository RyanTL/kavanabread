
<script src = "https://kit.fontawesome.com/bde2b79879.js" crossorigin = "anonymous"></script>

<div class="help-container">
    <button class="help-btn" id="helpBtn">
        <i class="fas fa-question"></i>
    </button>

    <div class="help-dropdown" id="helpDropdown">
        <div class="help-content">
            <?php
                if (isset($helpFile) && file_exists($helpFile)) {
                    include $helpFile;
                } else {
                    echo "<p>¿Necesitas ayuda?</p>";
                }
            ?>
        </div>
    </div>
</div>

<style>
    .help-container {
        position: fixed;
        bottom: 28px;
        right: 28px;
        z-index: 2000;
    }

    .help-btn {
        background: #496B5B;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        font-size: 20px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s ease-in-out;
    }

    .help-btn:hover {
        background: #2d4439;
        transform: scale(1.10);
    }

    .help-dropdown {
        position: absolute;
        bottom: calc(100% + 16px);
        right: 0;
        width: 280px;
        background: #FDD179;
        border: 2px solid #496B5B;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        border-radius: 12px;
        padding: 15px;
        opacity: 0;
        transform: translateY(10px);
        visibility: hidden;
        pointer-events: none;
        transition: all 0.25s ease;
    }

    .help-dropdown.show {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
        pointer-events: auto;
    }

    .help-dropdown::before {
        content: "";
        position: absolute;
        bottom: -8px;
        right: 8px;
        width: 14px;
        height: 14px;
        background: #FDD179;
        border-right: 2px solid #496B5B;
        border-bottom: 2px solid #496B5B;
        transform: rotate(45deg);
    }

    .help-content {
        font-size: 16px;
    }

    .help-content ul {
        padding-left: 18px;
        text-align: left;
    }

    .help-content li {
        margin-bottom: 10px;
    }

    .help-content h3 {
        margin-bottom: 8px;
        color: #496B5B;
        margin-bottom: 10px;
    }

    @media (min-width: 768px) {
        .help-dropdown {
            width: 320px;
        }
    }
</style>

<script>
    const helpBtn = document.getElementById("helpBtn");
    const helpDropdown = document.getElementById("helpDropdown");

    let closeTimeout;
    helpBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        clearTimeout(closeTimeout);
        helpDropdown.classList.toggle("show");
    });

    document.addEventListener("click", (e) => {
        if (!e.target.closest(".help-container")) {
            closeTimeout = setTimeout(() => {
                helpDropdown.classList.remove("show");
            }, 200);
        }
    });
    
    helpDropdown.addEventListener("mouseenter", () => {
        clearTimeout(closeTimeout);
    });
</script>
