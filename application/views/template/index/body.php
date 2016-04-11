<body>
<div id="main_container">
    <nav id="main_menu">
        <input type="button" id="register_show" class="show" value="Register"/>
        <input type="button" id="login_show" class="show" value="Login"/>
    </nav>
    <div id="data_container">
        <div class="form_container">
            <form class="register_form">
                <p>Username</p> <input type="text" id="username" name="username"/>
                <p>Password</p> <input type="password" id="password" name="password"/>
                <p>Retype password</p> <input type="password" id="con_password" name="con_password"/>
                <p>E-mail</p> <input type="text" id="email" name="email"/>
                <p id="error"></p><input type="button" value="Register" id="register"/>
            </form>
            <form class="login_form">
                <p>Username</p> <input type="text" id="login_username"/>
                <p>Password</p> <input type="password" id="login_password"/>
                <p id="login_error"></p><input type="button" id="login" value="Login"/>
            </form>
        </div>
        <div id="rules" class="welcome">
            <h1>Awakening - browser game</h1>
            <p id="info">Despre joc</p>
            <p id="buildings_info">Cladiri</p>
            <ul>
                <li>
                    <span id="main_building_info">Cladirea Principala :</span>
                    <ul id="main_building_info_list">
                        <li>- poti construi noi cladiri</li>
                        <li>- poti sa imbunatatesti cladiri</li>
                        <li>- poti sa distrugi cladiri</li>
                        <li>- bonus/level + 2% viteza de constructie</li>
                    </ul>
                </li>
                <li>
                    <span id="barracks_info">Cazarma :</span>
                    <ul id="barracks_info_list">
                        <li>- poti recruta trupe</li>
                        <li>- bonus/level + 10% mai multe locuri in cazarma, tipuri de soltati deblocati in functie de level</li>
                    </ul>
                </li>
                <li>
                    <span id="farm_info">Ferma :</span>
                    <ul id="farm_info_list">
                        <li>- poti recruta muncitori pentru a ii folosi in minereu sau la constructia/demolarea unei cladiri</li>
                        <li>- bonus/level + 2% mai multi muncitori ce vor locui la ferma</li>
                    </ul>
                </li>
                <li>
                    <span id="gold_info">Minereu :</span>
                    <ul id="gold_info_list">
                        <li>- poti insarcina muncitorii sa mineze pentru a descoperi aur</li>
                        <li>- bonus/level + 2% mai mult aur primit</li>
                    </ul>
                </li>
                <li>
                    <span id="market_info">Targ(Specific clasei) :</span>
                    <ul id="market_info_list">
                        <li>- Warrior: poate cumpara arme ce vor creste puterea soldatilor </li>
                        <li>- Wise: poate cumpara carti ce vor aduce la crearea de noi trupe (!noile trupe vor putea fi gasite doar la satele conduse de catre un caracter Wise(intelept) ) </li>
                        <li>- Mage: poate cumpara amulete,potiuni magice ce vor creste norocul trupelor/puterea(temporar) sau pentru a-si proteja satul</li>
                        <li>- bonus/level + noi iteme</li>
                    </ul>
                </li>
                <li>
                    <span id="gouvern_info">Guvern :</span>
                    <ul id="gouvern_info_list">
                        <li>- permite crearea a maximum 3 caractere , fiecare dintr-o clasa diferita :1 warrior, 1 wise si 1 mage - acestia putand cuceri un sat doar daca apartine clasei pe care o au</li>
                        <li>- max level:1</li>
                    </ul>
                </li>
                <li>
                    <span id="wall_info">Zid :</span>
                    <ul id="wall_info_list">
                        <li>- bonus/level +2% la defensiva </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

