//
//  Report.h
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Report : NSObject

@property (nonatomic, copy) NSString *title;
@property (nonatomic, copy) NSString *description;

-(id)initWithName:(NSString*)title description:(NSString *) description;

@end

