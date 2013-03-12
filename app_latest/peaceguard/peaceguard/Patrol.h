//
//  Patrol.h
//  peaceguard
//
//  Created by JonasYao on 2013-03-12.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreLocation/CoreLocation.h>

@interface Patrol : NSObject

@property (nonatomic) NSString *user_name;
@property (nonatomic) CLLocationDistance distance;
@property (nonatomic) NSMutableArray *history_locations;
@property (nonatomic, copy) NSString *final_location;
@property (nonatomic) NSString *start_location;
@property (nonatomic) NSTimeInterval *time;

-(id) initWithType: (NSString *) user_name distance: (CLLocationDistance *) distance history_locations: (NSMutableArray *) history_locations final_location: (NSString *) final_location start_location: (NSString *) start_location time: (NSTimeInterval) time;


@end
