import React from 'react';

interface Props {
    closeVar: () => void,
    message: string,
    type: string,
}

export const Alert = (props: Props) => {
    return (
        <div className={`alert-box alert-box--${props.type}`}>
            <div className="alert-box__icon">
                <i className={`fa fa-${props.type === 'success' ? 'check' : 'warning'}`} />
            </div>
            <div className="alert-box__content">
                {props.message}
            </div>
            <div className="alert-box__close" onClick={props.closeVar}>
                &times;
            </div>
        </div>
    );
}
