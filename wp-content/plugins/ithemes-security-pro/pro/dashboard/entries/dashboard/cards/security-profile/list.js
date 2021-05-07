/**
 * External dependencies
 */
import { get } from 'lodash';

/**
 * WordPress dependencies
 */
import { Dashicon, Button } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import { compose, withState, withInstanceId } from '@wordpress/compose';
import { withDispatch, withSelect } from '@wordpress/data';
import { Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { addFilter } from '../../hooks';
import Header, { Title, Status } from '../../components/card/header';
import MasterDetail, { Back } from '../../components/master-detail';
import UserInfo from './user-info';
import { getTwoFactor } from './utils';
import { withProps } from '@ithemes/security-hocs';

function MasterRender( { master } ) {
	return (
		<Fragment>
			<td className="itsec-card-security-profile__users--column-avatar">
				<img src={ master.avatar } alt="" />
			</td>
			<th scope="row" className="itsec-card-security-profile__users--column-username">
				{ master.name }
			</th>
			<td className="itsec-card-security-profile__users--column-role">
				{ master.role }
			</td>
			<td className="itsec-card-security-profile__users--column-two-factor">
				<Dashicon icon={ getTwoFactor( master.two_factor )[ 0 ] } />
				<span className="screen-reader-text">{ getTwoFactor( master.two_factor )[ 1 ] }</span>
			</td>
		</Fragment>
	);
}

function DetailRender( { master, pinUser, profileCards } ) {
	return (
		<section className="itsec-card-security-profile__user">
			<header className="itsec-card-security-profile__user-header">
				<img src={ master.avatar } alt="" />
				<h3>{ master.name }</h3>
				{ ! profileCards.includes( master.id ) && (
					<Button isLink onClick={ () => pinUser( master.id ) }>
						{ __( 'Pin', 'it-l10n-ithemes-security-pro' ) }
					</Button>
				) }
			</header>
			<UserInfo user={ master } />
		</section>
	);
}

function SecurityProfile( { card, config, eqProps, profileCards, pinUser, selected, setState } ) {
	const detailRender = withProps( { pinUser, profileCards } )( DetailRender );

	const select = ( id ) => setState( { selected: id } );
	const isSmall = eqProps[ 'max-width' ] && eqProps[ 'max-width' ].includes( '500px' );

	return (
		<div className="itsec-card--type-security-profile-list">
			<Header>
				<Back isSmall={ isSmall } select={ select } selectedId={ selected } />
				<Title card={ card } config={ config } />
				<Status />
			</Header>
			<MasterDetail masters={ card.data.users } detailRender={ detailRender } masterRender={ MasterRender }
				selectedId={ selected } select={ select } isSmall={ isSmall }>
				<thead>
					<tr>
						<th className="itsec-card-security-profile__users--column-avatar">
							<span className="screen-reader-text">
								{ __( 'Avatar', 'it-l10n-ithemes-security-pro' ) }
							</span>
						</th>
						<th className="itsec-card-security-profile__users--column-username">
							{ __( 'Username', 'it-l10n-ithemes-security-pro' ) }
						</th>
						<th className="itsec-card-security-profile__users--column-role">
							{ __( 'Role', 'it-l10n-ithemes-security-pro' ) }
						</th>
						<th className="itsec-card-security-profile__users--column-two-factor">
							{ __( '2FA', 'it-l10n-ithemes-security-pro' ) }
						</th>
					</tr>
				</thead>
			</MasterDetail>
		</div>
	);
}

export const slug = 'security-profile-list';
export const settings = {
	render: compose( [
		withState( { selected: 0 } ),
		withInstanceId,
		withDispatch( ( dispatch, ownProps ) => ( {
			pinUser( uid ) {
				dispatch( 'ithemes-security/dashboard' ).saveDashboardCard( ownProps.dashboardId, {
					card: 'security-profile',
					settings: {
						user: uid,
					},
				} );
			},
		} ) ),
		withSelect( ( select, ownProps ) => ( {
			profileCards: select( 'ithemes-security/dashboard' ).getDashboardCards( ownProps.dashboardId ).filter( ( card ) => card.card === 'security-profile' ).map( ( card ) => get( card, [ 'data', 'user', 'id' ] ) ),
		} ) ),
	] )( SecurityProfile ),
	elementQueries: [
		{
			type: 'width',
			dir: 'max',
			px: 500,
		},
		{
			type: 'width',
			dir: 'min',
			px: 501,
		},
		{
			type: 'width',
			dir: 'max',
			px: 700,
		},
	],
};

addFilter( 'dashboard.getCardTitle.security-profile', 'ithemes-security/security-profile/default', function( title, card ) {
	if ( card.data.user && card.data.user.name ) {
		return sprintf( __( 'Security Profile – %s', 'it-l10n-ithemes-security-pro' ), card.data.user.name );
	}

	if ( card.settings && card.settings.user ) {
		return sprintf( __( 'User (%d) Security Profile', 'it-l10n-ithemes-security-pro' ), card.settings.user );
	}

	return title;
} );
