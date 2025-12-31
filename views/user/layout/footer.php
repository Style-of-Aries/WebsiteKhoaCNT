<div class="playSongs">
    <div class="inforSong">
        <div class="imageSong">
            <img id="imgSong" src="" alt="" onerror="this.style.display='none';">
        </div>
        <div class="textInfor">
            <div id="nameSong" class="nameSong"></div>
            <div id="nameArtist" class="nameArtist"></div>
        </div>
        <div id="favoriteBtn" class="favoriteBtn" data-id="">
            <i class="fa-regular fa-heart"></i>
        </div>
    </div>
    <div class="player-controls">
        <audio id="music" src="" ></audio>
        <div class="control-buttons">
            <div id="randomBtn">
                <i class="fa-solid fa-shuffle"></i>
            </div>
            <i id="prevBtn" class="fa-solid fa-backward-step"></i>
            <div id="playBtn">
                <i class="fa-solid fa-circle-play center-button"></i>
            </div>
            <i id="nextBtn" class="fa-solid fa-forward-step"></i>
            <div id="repeatBtn">
                <i class="fa-solid fa-repeat"></i>
            </div>
        </div>
        <div class="time-line">
            <span id="timeChay">--:--</span>
            <input type="range" id="rangeAudio" min="0" max="0" value="100">
            <span id="timeSong">--:--</span>
        </div>
    </div>
    <div class="playSong-left">
        <div class="volume">
            <div id="volumeBtn">
                <i class="fa-solid fa-volume-high"></i>
            </div>
            <input type="range" id="rangeVolume" min="0" max="100" value="100">

        </div>
    </div>
</div>