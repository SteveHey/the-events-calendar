/**
 * External dependencies
 */
import React, { Fragment, useContext } from 'react';
import PropTypes from 'prop-types';
import classNames from 'classnames';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { PlainText } from '@wordpress/editor';

/**
 * Internal dependencies
 */
import {
	TimeZone,
} from '@moderntribe/events/elements';
import {
	date,
	moment as momentUtil,
} from '@moderntribe/common/utils';
import { editor, settings } from '@moderntribe/common/utils/globals';
import HumanReadableInput from '../../human-readable-input/container';
import ContentHook from './hook';
import Controls from '../../controls';
import DateTimeContext from '../../context';

/**
 * Module Code
 */

const { FORMATS, TODAY } = date;
const {
	toMoment,
	toDate,
	toDateNoYear,
	toTime,
	isSameYear,
} = momentUtil;
FORMATS.date = settings() && settings().dateWithYearFormat
	? settings().dateWithYearFormat
	: __( 'F j', 'the-events-calendar' );

/**
 * Renders a separator based on the type called
 *
 * @param {string} type - The type of separator
 *
 * @returns {ReactDOM} A React Dom Element null if none.
 */
const renderSeparator = ( props, type, className ) => {
	const { separatorDate, separatorTime } = props;

	switch ( type ) {
		case 'date-time':
			return (
				<span className={ classNames( 'tribe-editor__separator', className ) }>
					{ ' '.concat( separatorDate, ' ' ) }
				</span>
			);
		case 'time-range':
			return (
				<span className={ classNames( 'tribe-editor__separator', className ) }>
					{ ' '.concat( separatorTime, ' ' ) }
				</span>
			);
		case 'all-day':
			return (
				<span className={ classNames( 'tribe-editor__separator', className ) }>{ __( 'All Day', 'the-events-calendar' ) }</span>
			);
		default:
			return null;
	}
}

const renderPrice = ( { cost, currencyPosition, currencySymbol, setCost } ) => {
	// Bail when not classic
	if ( ! editor() || ! editor().isClassic ) {
		return null;
	}

	return (
		<div
			key="tribe-editor-event-cost"
			className="tribe-editor__event-cost"
		>
			{ 'prefix' === currencyPosition && <span>{ currencySymbol }</span> }
			<PlainText
				className={ classNames( 'tribe-editor__event-cost__value', `tribe-editor-cost-symbol-position-${ currencyPosition }` ) }
				value={ cost }
				placeholder={ __( 'Enter price', 'the-events-calendar' ) }
				onChange={ setCost }
			/>
			{ 'suffix' === currencyPosition && <span>{ currencySymbol }</span> }
		</div>
	);
};

const renderStartDate = ( { start, end } ) => {
	let startDate = toDate( toMoment( start ) );

	if ( isSameYear( start, end ) && isSameYear( start, TODAY ) ) {
		startDate = toDateNoYear( toMoment( start ) );
	}

	return (
		<span className="tribe-editor__subtitle__headline-date">{ startDate }</span>
	);
};

const renderStartTime = ( props ) => {
	const { start, allDay } = props;

	if ( allDay ) {
		return null;
	}

	return (
		<Fragment>
			{ renderSeparator( props, 'date-time' ) }
			{ toTime( toMoment( start ), FORMATS.WP.time ) }
		</Fragment>
	);
};

const renderEndDate = ( { start, end, multiDay } ) => {
	if ( ! multiDay ) {
		return null;
	}

	let endDate = toDate( toMoment( end ) );

	if ( isSameYear( start, end ) && isSameYear( start, TODAY ) ) {
		endDate = toDateNoYear( toMoment( end ) );
	}

	return (
		<span className="tribe-editor__subtitle__headline-date">{ endDate }</span>
	);
};

const renderEndTime = ( props ) => {
	const { end, multiDay, allDay, sameStartEnd } = props;

	if ( allDay || sameStartEnd ) {
		return null;
	}

	return (
		<Fragment>
			{ multiDay && renderSeparator( props, 'date-time' ) }
			{ toTime( toMoment( end ), FORMATS.WP.time ) }
		</Fragment>
	);
}

const renderTimezone = () => {
	const { setTimeZoneLabel, timeZoneLabel, showTimeZone } = useContext(DateTimeContext);

	return showTimeZone && (
		<span
			key="time-zone"
			className="tribe-editor__time-zone"
		>
			<TimeZone
				value={ timeZoneLabel }
				placeholder={ timeZoneLabel }
				onChange={ setTimeZoneLabel }
			/>
		</span>
	);
}

const renderExtras = ( props ) => {
	return (
		<Fragment>
			{ renderTimezone() }
			{ renderPrice( props ) }
		</Fragment>
	);
}

const EventDateTimeContent = ( props ) => {
	const {
		multiDay,
		allDay,
		sameStartEnd,
		isEditable,
		setAttributes,
	} = props;

	const {
		isOpen,
		open,
		showTimeZone,
		setShowTimeZone,
		setDateTimeAttributes,
	} = useContext(DateTimeContext);

	const controlProps = {
		showTimeZone,
		setShowTimeZone,
		setDateTimeAttributes,
	};

	return (
		<Fragment>
			<Controls { ...controlProps } />
			{
				isOpen && isEditable
					? <HumanReadableInput
							after={ renderExtras( props ) }
							setAttributes={ setAttributes }
						/>
					: (
						<Fragment>
							<h2 className="tribe-editor__subtitle__headline">
								<div className="tribe-editor__subtitle__headline-content">
									<button
										className="tribe-editor__btn--label"
										onClick={ open }
										disabled={ ! isEditable }
									>
										{ renderStartDate( props ) }
										{ renderStartTime( props ) }
										{ ( multiDay || ( ! allDay && ! sameStartEnd ) ) && renderSeparator( props, 'time-range' ) }
										{ renderEndDate( props ) }
										{ renderEndTime( props ) }
										{ allDay && renderSeparator( props, 'all-day' ) }
									</button>
									{ renderExtras( props ) }
								</div>
							</h2>
							<ContentHook />
						</Fragment>
					)
			}
		</Fragment>
	);
};

EventDateTimeContent.propTypes = {
	allDay: PropTypes.bool,
	cost: PropTypes.string,
	currencyPosition: PropTypes.oneOf( [ 'prefix', 'suffix', '' ] ),
	currencySymbol: PropTypes.string,
	end: PropTypes.string,
	isEditable: PropTypes.bool,
	isOpen: PropTypes.bool,
	multiDay: PropTypes.bool,
	open: PropTypes.func,
	sameStartEnd: PropTypes.bool,
	separatorDate: PropTypes.string,
	separatorTime: PropTypes.string,
	setCost: PropTypes.func,
	start: PropTypes.string,
};

export default EventDateTimeContent;
