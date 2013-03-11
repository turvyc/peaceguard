//
//  PatrolDataController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "Patrol.h"
#import "PatrolDataController.h"

@interface PatrolDataController : NSObject

@property (nonatomic, copy) Patrol *currentPatrol;

-(void)beginPatrol;

@end
