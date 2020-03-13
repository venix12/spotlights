import React from 'react';

interface Props {
    comment: Vote,
}

class NominationComment extends React.Component<Props> {
    getVoteName = (value: number) => {
        switch (value) {
            case -1:
                return 'criticizer';
            case 0:
                return 'neutral';
            case 1:
                return 'supporter';
            case 2:
                return 'contributor';
            default:
                return 'nominator';
        }
    }

    render() {
        const { comment } = this.props;
        const voteName = this.getVoteName(comment.value);

        return (
            <div className={`comment-card comment-card--${voteName}`}>
                <div className="comment-card__header">
                    {comment.voter.username}
                    <div className="comment-card__header__dot" />
                    <div className="comment-card__header__state">
                        {voteName}
                    </div>
                </div>

                <div className="comment-card__content">
                    <span className="comment-card__content__content">{comment.comment}</span>

                    <div className="comment-card__info">
                        <div className="comment-card__info__el">{`created at ${comment.created_at}`}</div>

                        {comment.comment_updated_at && <div className="comment-card__info__el">
                            {`updated at ${comment.comment_updated_at}`}
                        </div>}
                    </div>
                </div>
            </div>
        );
    }
}

export default NominationComment;
