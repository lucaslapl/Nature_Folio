<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="robots" content="noindex">
    <title>Lucas Laplanche - Ajout d'oiseau</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #070707;
            --surface: #0f0f0f;
            --text-main: #ffffff;
            --text-muted: #666666;
            --neon-green: #a0ff8e;
            --border: #1a1a1a;
            --transition: all 0.3s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background: var(--surface);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 30px;
            letter-spacing: -1px;
            color: var(--neon-green);
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        input[type="text"], 
        input[type="url"], 
        input[type="date"], 
        select, 
        textarea {
            width: 100%;
            background: #050505;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 12px 15px;
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            transition: var(--transition);
            outline: none;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--neon-green);
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.1);
        }

        #fillRepartition {
            background: transparent;
            border: 1px solid var(--neon-green);
            color: var(--neon-green);
            font-size: 0.65rem;
            text-transform: uppercase;
            padding: 5px 10px;
            border-radius: 4px;
            margin-top: 8px;
            cursor: pointer;
            transition: var(--transition);
        }

        #fillRepartition:hover {
            background: var(--neon-green);
            color: var(--bg);
        }

        input[type="file"] {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .submit-btn {
            width: 100%;
            background: var(--neon-green);
            color: var(--bg);
            border: none;
            padding: 15px;
            border-radius: 6px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 20px;
        }

        .submit-btn:hover {
            box-shadow: 0 0 20px rgba(0, 243, 255, 0.4);
            transform: translateY(-2px);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 500px) {
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Ajouter une espèce</h2>

        <form action="bird_sent.php" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Nom de l'oiseau</label>
                <input type="text" name="name" placeholder="Ex: Mésange charbonnière">
            </div>

            <div class="form-group">
                <label>Nom latin</label>
                <input type="text" name="namelatin" placeholder="Ex: Parus major">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Famille</label>
                    <input type="text" name="famille" placeholder="Ex: Paridae">
                </div>
                <div class="form-group">
                    <label>Rareté</label>
                    <select id="rarete" name="rarete">
                        <option value="Commune">Commune</option>
                        <option value="Peu commune">Peu commune</option>
                        <option value="Rare">Rare</option>
                        <option value="Très rare">Très rare</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Répartition</label>
                <textarea id="repartition" name="repartition" rows="3"></textarea>
                <button id="fillRepartition" type="button" data-value="Observable sur tout le territoire métropolitain.">Auto-remplir : Territoire complet</button>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea id="description" name="description" rows="3"></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Première observation</label>
                    <input type="date" id="first-obs" name="first-obs">
                </div>
                <div class="form-group">
                    <label>Date photo</label>
                    <input type="date" id="date-photo" name="date-photo">
                </div>
            </div>

            <div class="form-group">
                <label>Fiche INPN (URL)</label>
                <input type="url" name="lien-inpn" placeholder="https://inpn.mnhn.fr/...">
            </div>

            <div class="form-group">
                <label>Lieu photo</label>
                <input type="text" name="lieu-photo">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label>Photo principale</label>
                    <input type="file" name="imgMain" id="imgMain">
                </div>
                <div class="form-group">
                    <label>Miniature</label>
                    <input type="file" name="imgMini" id="imgMini">
                </div>
            </div>

            <input type="submit" value="Enregistrer l'espèce" name="submit" class="submit-btn">
        </form>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#fillRepartition').click(function () {
            const valeur = $(this).data('value');
            $('#repartition').val(valeur);
        });
    });
</script>
</body>
</html>
