import React, {useState, useEffect} from 'react'
import Modal from 'react-bootstrap/Modal';



const VideoPlayer = ({ id, showPlayer, hideVideo }) => {


    console.log(id)
    return (
            <Modal
                size="lg"
                show={showPlayer}
                onHide={() => hideVideo(id)}
                aria-labelledby="example-modal-sizes-title-lg"
            >
                <Modal.Header closeButton>
                    <Modal.Title id="example-modal-sizes-title-lg">
                        Large Modal
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="embed-responsive embed-responsive-16by9">
                        <iframe className="embed-responsive-item"
                                src={"https://www.youtube.com/embed/"+id+"?rel=0"}
                                allowFullScreen></iframe>
                    </div>
                </Modal.Body>
            </Modal>
    );
}


export {VideoPlayer}
