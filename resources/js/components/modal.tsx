import React from 'react';

interface Props {
    close: any,
    content: JSX.Element,
    title: string,
}

const Modal = (props: Props) => {
    return (
        <div>
            <div className="modal__backdrop" onClick={props.close} />

            <div className="modal__card">
                <div className="modal__header">
                    <div className="modal__header__title">
                        {props.title}
                    </div>

                    <span className="modal__header__close" onClick={props.close}>
                        &times;
                    </span>
                </div>
                <div className="modal__content">
                    {props.content}
                </div>
            </div>
        </div>
    )
}

export default Modal;
