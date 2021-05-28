import React from 'react';

interface Props {
    vote: Vote,
}

class NominationComment extends React.Component<Props> {
    getVoteName = (value: number) => {
        return value !== null
            ? `voted ${value}`
            : 'nominator';
    }

    render() {
        const { vote } = this.props;
        const voteName = this.getVoteName(vote.value);

        return (
            <div className={`comment-card comment-card--${voteName}`}>
                <div className="comment-card__header">
                    {vote.voter.username}
                    <div className="comment-card__header__dot" />
                    <div className="comment-card__header__state">
                        {voteName}
                    </div>
                </div>

                <div className="comment-card__content">
                    <span className="comment-card__content__content">{vote.comment}</span>

                    <div className="comment-card__info">
                        <div className="comment-card__info__el">{`created at ${vote.created_at}`}</div>

                        {vote.comment_updated_at && <div className="comment-card__info__el">
                            {`updated at ${vote.comment_updated_at}`}
                        </div>}
                    </div>
                </div>
            </div>
        );
    }
}

export default NominationComment;
