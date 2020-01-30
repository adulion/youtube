import React from 'react';
import {VideoPlayer} from "./VideoPlayer";


const styles = {
    width: '18rem'
}



const Thumbnail = ({ id, title, thumbnail, showVideo }) => {

    var defaultTitle = '';
    var defaultThumbnail = '/worksmart.gif';

    return (
        <div className="card" style={styles}>
            <img className="card-img-top" src={thumbnail ? thumbnail : defaultTitle} alt="Card image cap" />
                <div className="card-body">
                    <h5 className="card-title">{title ? title : defaultThumbnail}</h5>
                    <a href="#" className="btn btn-primary" onClick={()=>showVideo(id)} >View</a>
                </div>


        </div>
    )
}




export {Thumbnail}

